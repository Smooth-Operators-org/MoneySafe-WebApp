$(document).ready(function () {
  // Inicializar Funciones Materialize
  $(".sidenav").sidenav();
  $(".modal").modal();
  $("select").formSelect();
  $(".datepicker").datepicker();
  $(".tooltipped").tooltip();

  var obj = {};

  // Limpiar inputs del modal
  $("#btn-cancelas").click(function () {
    $("input[type = text]").val("");
    $("#cant_ing").val("");
    $("input[type=checkbox]").prop("checked", false);
    $("input").removeClass("valid");
    $("input").removeClass("invalid");
    // console.log("holass");

  });

  //Boton Insertar
  $(".btn-new-ingreso").click(function () {
    obj = {
      accion: "insertIngreso"
    };
    $("#modal-title").text("Nuevo Ingreso");
    $("#btn-form").text("Registrar");
  });

  //Boton Editar
  $(".btn-edit").click(function () {
    let id = $(this).attr("data-modal");
    obj = {
      accion: "getIngreso",
      id: id
    };
    $.post(
      "/modulos/ingresos/consultas.php",
      obj,
      function (respuesta) {
        $("#nombre_ing").val(respuesta.nombre_ing);
        $("#cant_ing").val(respuesta.cant_ing);
        $("#desc_ing").val(respuesta.desc_ing);
        $("#fecha_ing").val(respuesta.fecha_ing);
        $("#recurrente_ing").val(respuesta.recurrente_ing);

        if (respuesta.recurrente_ing == "1") {
          $("#recurrente_ing").prop("checked", true);
        } else if (respuesta.recurrente_ing == "0") {
          $("#recurrente_ing").prop("checked", false);
        }

        obj = {
          accion: "updateIngreso",
          id: id
        };
      },
      "JSON"
    );
    $("#modal-title").text("Editar Ingreso");
    $("#btn-form").text("Editar");
  });

  $('.modal-info').click(function () {
    let id = $(this).attr('data');
    obj = {
      accion: 'getData',
      id: id
    };
    console.log(obj);
    $.post('../../includes/consultas.php', obj, function (respuesta) {
      $('#nombre_usr_info').val(respuesta.nombre_usr);
      if (respuesta.plan_deseado == "0" || respuesta.plan_deseado == 0) {
        $('#id_plan').val('0');
      } else {
        $('#id_plan').val(respuesta.plan_deseado);
      }
      obj = {
        accion: 'updateData',
        id: id
      };
    }, 'JSON');
  });

  $('#btn-modal-info').click(function () {
    $('#modal-info-perfil').find('input').map(function (i, e) {
      obj[$(this).prop('name')] = $(this).val();
    });
    $("#modal-info-perfil").find("select").map(function (i, e) {
      obj[$(this).prop("name")] = $(this).val();
    });
    switch (obj.accion) {
      case 'updateData':
        $.post('../../includes/consultas.php', obj, function (respuesta) {
          if (respuesta.status == 0) {
            swal('¡ERROR!', 'Tu nombre no puede quedar vacío', 'error');
          } else if (respuesta.status == 1) {
            swal('Éxito', 'Datos actualizados correctamente', 'success').then(() => {
              location.reload();
            });
          }
        }, 'JSON');
        break;
      default:
        break;
    }
  });

  //Boton Insertar/Editar del Modal
  $("#btn-form-ingresos").click(function () {
    $("#modal-ingresos")
      .find("input")
      .map(function (i, e) {
        obj[$(this).prop("name")] = $(this).val();
        if ($(this).prop("type") == "checkbox") {
          obj[$(this).prop("name")] = $(this).prop("checked");
        }
      });

    switch (obj.accion) {
      case "insertIngreso":
        $.post(
          "/modulos/ingresos/consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 2) {
              swal(
                "PLAN AGOTADO",
                "Tu cantidad de Ingresos a llegado a su máximo número de registros en el mes seleccionado",
                "warning"
              ).then(() => {
                location.reload();
              });
            } else if(respuesta.status == 3){
              // alert(respuesta.status);
              swal("PLAN AGOTADO", "Tu cuenta expira antes que la fecha seleccionada", "warning");
            }else if (respuesta.status == 1) {
              swal("Éxito", "Ingreso registrado correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            }
          },
          "JSON"
        );
        break;

      case "updateIngreso":
        $.post(
          "/modulos/ingresos/consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 2) {
              swal(
                "MES AGOTADO",
                "Tu cantidad de Ingresos a llegado a su máximo número de registros en el mes seleccionado",
                "warning"
              ).then(() => {
                location.reload();
              });
            } else if(respuesta.status == 3){
              // alert(respuesta.status);
              swal("PLAN AGOTADO", "Tu cuenta expira antes que la fecha seleccionada", "warning");
            }else if (respuesta.status == 1) {
              swal("Éxito", "Ingreso editado correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            }
          },
          "JSON"
        );
        break;

      default:
        break;
    }
  });

  $(".btn-delete").click(function () {
    let id = $(this).attr("data-modal");
    obj = {
      accion: "deleteIngreso",
      id: id
    };
    swal({
      title: "¿Estás seguro?",
      text: "El ingreso será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "/modulos/ingresos/consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "Ingreso eliminado correctamente", "success").then(
                willDelete => {
                  location.reload();
                }
              );
            }
          },
          "JSON"
        );
      }
    });
  });
});
