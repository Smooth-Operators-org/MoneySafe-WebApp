$(document).ready(function(){
//Guardar Coockies
    var remember = $.cookie("remember");
    if (remember == "true") {
        var email = $.cookie("email");
        var password = $.cookie("password");
        $("#email").val(email)
        $("#password").val(password)
        $("#remember").prop("checked", remember);
    }

    function processLogin() {
        let obj = {
          accion: "login",
        };

        $("#login-form").find("input").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
            if ($(this).prop("type") == "checkbox") {
              obj[$(this).prop("name")] = $(this).prop("checked");
            }
        });

        if (obj.remember == true) {
            $.cookie("email", obj.email, {
              expires: 30
            });
            $.cookie("password", obj.password, {
              expires: 30
            });
            $.cookie("remember", true, {
              expires: 30
            });
        } else {
            $.cookie("email", null);
            $.cookie("password", null);
            $.cookie("remember", false);
        }

        $.post( "consultas.php", obj, function (respuesta) {
            if (respuesta.days == 0 && respuesta.plan == 1) {
              swal("¡PLAN AGOTADO!", "Tu prueba ah terminado", "error").then(
                () => {
                  window.location.href = "../../includes/close_session.php";
                }
              );
            }else if (respuesta.days == 0 && respuesta.plan > 1) {
              swal("¡PLAN AGOTADO!", "Tu plan contratado ah terminado", "error").then(
                () => {
                  window.location.href = "../../includes/close_session.php";
                }
              );
            }else{
              if (respuesta.status == 3) {
                if(respuesta.nivelusr == 1){
                  window.location.href = "../usuarios/index.php";
                }else{
                  window.location.href = "../../index.php";
                }
              }
            }
            if (respuesta.status == 5) {
              swal("¡ERROR!", "Campos vacios", "error");
            }
            if (respuesta.status == 2) {
              swal("¡ERROR!", "Contraseña incorrecta", "error");
            }
            if (respuesta.status == 4) {
              swal("¡ERROR!", "Usuario no registrado", "error");
            }
            if (respuesta.status == 6) {
              swal("¡CUENTA SIN ACTIVAR!", "Esta cuenta aún no ha sido activada, en unos momentos se activará su cuenta", "error");
            }
          },"JSON"
        );
    }

    $("#btn-login").click(function () {
        processLogin();
    });
    
    $("#email, #password, #remember").keyup(function (e) {
        if (e.keyCode == 13) {
          processLogin();
        }
    });

    function processRegister() {
        let obj = {
          accion: "register"
        }
        $("#register-form").find("input, select").map(function (i, e) {
          obj[$(this).prop("name")] = $(this).val();
        });
        $.post("consultas.php", obj, function (respuesta) {
          if (respuesta.status == 0) {
            swal("¡ERROR!", "Campos vacios", "error");
          } else if (respuesta.status == 1) {
            swal("Éxito", "Su cuenta ha sido creada correctamente", "success").then(
              () => {
                location.reload();
              }
            );
          } else if (respuesta.status == 4) {
            swal("¡ERROR!", "Inserta una derección de email valida", "error");
          } else if (respuesta.status == 2) {
            swal("¡ERROR!", "Este email ya ha sido registrado", "error");
          } else if (respuesta.status == 3) {
            swal("¡ERROR!", "Passwords no coinciden", "error");
          }
        }, "JSON");
    }

    $("#btn-register").click(function () {
        processRegister();
    });
    
    $("#nombre_usr, #correo_usr, #password_usr, #re_password_usr, #id_plan").keyup(function (e) {
        if (e.keyCode == 13) {
          processRegister();
        }
    });

//Iniciar Select Materialize
    $('select').formSelect();
//Cambiar Form
    $("#mensaje a").click(function () {
        $("form").animate({
            height: "toggle",
            opacity: "toggle",
          },
          "slow"
        );
    });
});