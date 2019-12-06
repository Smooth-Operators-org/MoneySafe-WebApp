$(document).ready(function () {
  //MATERIALIZE
  $(".sidenav").sidenav();
  $(".modal").modal();
  $("select").formSelect();
  $(".datepicker").datepicker();
  $(".tooltipped").tooltip();
  var obj = {};

  //LIMPIAR MODAL
  $("#btn-cancel").click(function () {
    $("input[type = text]").val("");
    $("#cant_ing").val("");
    $("input[type=checkbox]").prop("checked", false);
    $("input").removeClass("valid");
    $("input").removeClass("invalid");
  });

  //CONFIGURACIÓN DE FECHAS
  function getMonthFromNumber(Number) {
    var Months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ];
    return Months[Number];
  }

  //VARIABLES FECHAS
  var date = new Date();
  let MonthN = date.getMonth();
  let Year = date.getFullYear();
  let MonthName = getMonthFromNumber(MonthN);
  let FullDate = MonthName + ', ' + Year;
  $('#fecha_nueva').text(FullDate);

  //EJECUTAR FUNCIONES
  consultarIngresos(MonthN, Year);
  sumarIngresos(MonthN, Year);

  //FUNCION PARA CONSULTAR INGRESOS
  function consultarIngresos(MonthN, Year) {
      let id = $(".modal-info").attr('data');
      let obj = {
          "accion": "getDataIngresos",
          "month": MonthN,
          "year": Year,
          "id": id
      };
      var hostName = $(location).attr('hostname');
      var http = "http://";
      var direc = "/MoneySafe-WebApp";
      var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
      $.post(ruta, obj, function (respuesta) {
          let templateIngresos = ``;
          $.each(respuesta, function (i, e) {
              if (e.recurrente_ing == 2){
                templateIngresos += `
                <tr>
                <td>${e.nombre_ing}</td>
                <td>${"$ "+e.cant_ing}</td>
                <td>${e.desc_ing}</td>
                <td>${e.fecha_ing}</td>
                <td>
                  <a href="#modal-ingresos" data-modal="${e.id_ing}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                  <a href="#" data-modal="${e.id_ing}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                </td>
                </tr>`;
              }else if (e.recurrente_ing == 0) {
                var rec = "No";
                templateIngresos += `
                <tr>
                <td>${e.nombre_ing}</td>
                <td>${"$ "+e.cant_ing}</td>
                <td>${e.desc_ing}</td>
                <td>${e.fecha_ing}</td>
                <td>${rec}</td>
                <td>
                  <a href="#modal-ingresos" data-modal="${e.id_ing}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                  <a href="#" data-modal="${e.id_ing}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                </td>
                </tr>`;
              }else if(e.recurrente_ing == 1){
                var rec = "Si";
                templateIngresos += `
                <tr>
                <td>${e.nombre_ing}</td>
                <td>${"$ "+e.cant_ing}</td>
                <td>${e.desc_ing}</td>
                <td>${e.fecha_ing}</td>
                <td>${rec}</td>
                <td>
                  <a href="#modal-ingresos" data-modal="${e.id_ing}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                  <a href="#" data-modal="${e.id_ing}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                </td>
                </tr>`;
              }
          });
          $("#Ingresos tbody").html(templateIngresos);
      }, "JSON");
  }

  //FUNCION PARA SUMAR INGRESOS
  function sumarIngresos(MonthN, Year) {
      let id = $(".modal-info").attr('data');
      let obj = {
          "accion": "sumarIngresos",
          "month": MonthN,
          "year": Year,
          "id": id
      };
      var hostName = $(location).attr('hostname');
      var http = "http://";
      var direc = "/MoneySafe-WebApp";
      var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
      $.post(ruta, obj, function (respuesta) {
          $.each(respuesta, function (i, e) {
              if (e.total == 0 || e.total == "" || e.total == null) {
                  e.total = 0;
                  $('#totalIngreso').text("$ " + e.total);                  
              } else {
                  $('#totalIngreso').text("$ " + e.total);
              }
          });
      }, "JSON");
  }

  //BOTON INSERTAR
  $(".btn-new-ingreso").click(function () {
    obj = {
      accion: "insertIngreso"
    };
    $("#modal-title").text("Nuevo Ingreso");
    $("#btn-form").text("Registrar");
  });

  //BOTON EDITAR
  $("#Ingresos").on("click", ".btn-edit", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-modal");
    obj = {
      accion: "getIngreso",
      id: id
    };
    var hostName = $(location).attr('hostname');
    var http = "http://";
    var direc = "/MoneySafe-WebApp";
    var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
    $.post(
      ruta,
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

  //BOTON ELIMINAR
  $("#Ingresos").on("click", ".btn-delete", function (e) {
    e.preventDefault();
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
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
        $.post(
          ruta,
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

  //MOSTRAR DATOS DEL USUARIO
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

  //UPDATE DATOS USUARIO
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
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
        $.post(
          ruta,
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
            } else if (respuesta.status == 3){
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
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/ingresos/consultas.php";
        $.post(
          ruta,
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if(respuesta.status == 3){
              swal("PLAN AGOTADO", "Tu cuenta expira antes que la fecha seleccionada", "warning");
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
  //BOTONES ATRAS Y ADELANTE FECHAS
  $('#left').click(function () {
    date.setMonth(date.getMonth() - 1);
    let MonthN = date.getMonth();
    let Year = date.getFullYear();
    let MonthName = getMonthFromNumber(MonthN);
    let FullDate = MonthName + ', ' + Year;
    $('#fecha_nueva').text(FullDate);
    consultarIngresos(MonthN, Year);
    sumarIngresos(MonthN, Year);
  });

  $("#right").click(function () {
    date.setMonth(date.getMonth() + 1);
    let MonthN = date.getMonth();
    let Year = date.getFullYear();
    let MonthName = getMonthFromNumber(MonthN);
    let FullDate = MonthName + ', ' + Year;
    $('#fecha_nueva').text(FullDate);
    consultarIngresos(MonthN, Year);
    sumarIngresos(MonthN, Year);
  });
});
