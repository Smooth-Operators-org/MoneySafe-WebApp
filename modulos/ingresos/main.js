$(document).ready(function() {
  // Inicializar Funciones Materialize
  $(".sidenav").sidenav();
  $(".modal").modal();
  $("select").formSelect();
  $(".datepicker").datepicker();
  $(".tooltipped").tooltip();

  var obj = {};

  // Limpiar inputs del modal
  $("#btn-cancel-modal").click(function() {
    $("input").removeClass("valid");
    $("input").removeClass("invalid");
    $("input[type=text]").val("");
    $("input[type=number]").val("");
    $("input[type=checkbox]").prop("checked", false);
  });

  $(".btn-new").click(function() {
    obj = {
      accion: "insertIngreso"
    };
    $("#modal-title").text("Nuevo Ingreso");
    $("#btn-form").text("Registrar");
  });

  $(".btn-edit").click(function() {
    let id = $(this).attr("data-modal");
    obj = {
      accion: "getIngreso",
      id: id
    };
    $.post(
      "/modulos/ingresos/funciones.php",
      obj,
      function(respuesta) {
        $("#nombre_ing").val(respuesta.nombre_ing);
        $("#cant_ing").val(respuesta.cant_ing);
        $("#desc_ing").val(respuesta.desc_ing);
        $("fecha_ing").val(respuesta.fecha_ing);
        $("fecha_reg").val(respuesta.fecha_reg);
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

  $(".btn-delete").click(function() {
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
          "/modulos/ingresos/funciones.php",
          obj,
          function(respuesta) {
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

  $("#btn-form").click(function() {
    $("#modal-ingresos")
      .find("input")
      .map(function(i, e) {
        obj[$(this).prop("name")] = $(this).val();
        if ($(this).prop("type") == "checkbox") {
          obj[$(this).prop("name")] = $(this).prop("checked");
        }
      });
    switch (obj.accion) {
      case "insertIngreso":
        $.post(
          "/modulos/ingresos/funciones.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 2) {
              // alert(respuesta.sesion + respuesta.registros);
              swal(
                "PLAN AGOTADO",
                "Tu cantidad de Ingresos a llegado a su máximo número de registros",
                "warning"
              ).then(() => {
                location.reload();
              });
            } else if (respuesta.status == 1) {
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
          "/modulos/ingresos/funciones.php",
          obj,
          function(respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
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
});
