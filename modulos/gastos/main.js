$(document).ready(function () {
    //MOSTRAR DATOS USUARIO
    $('.modal-info').click(function () {
        let id = $(this).attr('data');
        obj = {
            accion: 'getData',
            id: id
        };
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

    //EDITAR DATOS USUARIO
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

    // MATERIALIZE
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();
    var obj = {};

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
    consultarGastos(MonthN, Year);
    sumarGastos(MonthN, Year);

    //FUNCION PARA CONSULTAR GASTOS
    function consultarGastos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "getDataGastos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
        $.post(ruta, obj, function (respuesta) {
            let templateGastos = ``;
            $.each(respuesta, function (i, e) {
                if (e.recurrente_gst == 2) {
                    templateGastos += `
                    <tr>
                    <td>${e.nombre_gst}</td>
                    <td>${e.nombre_cat}</td>
                    <td>${"$ "+e.cant_gst}</td>
                    <td>${e.desc_gst}</td>
                    <td>${e.fecha_gst}</td>
                    <td>
                    <a href="#modal-gastos" data-modal="${e.id_gst}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                    <a href="#" data-modal="${e.id_gst}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                    </td>
                    </tr>`;
                }else if(e.recurrente_gst == 1){
                    var rec = "Si";
                    templateGastos += `
                    <tr>
                    <td>${e.nombre_gst}</td>
                    <td>${e.nombre_cat}</td>
                    <td>${"$ "+e.cant_gst}</td>
                    <td>${e.desc_gst}</td>
                    <td>${e.fecha_gst}</td>
                    <td>${rec}</td>
                    <td>
                    <a href="#modal-gastos" data-modal="${e.id_gst}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                    <a href="#" data-modal="${e.id_gst}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                    </td>
                    </tr>`;
                }else if(e.recurrente_gst == 0){
                    var rec = "No";
                    templateGastos += `
                    <tr>
                    <td>${e.nombre_gst}</td>
                    <td>${e.nombre_cat}</td>
                    <td>${"$ "+e.cant_gst}</td>
                    <td>${e.desc_gst}</td>
                    <td>${e.fecha_gst}</td>
                    <td>${rec}</td>
                    <td>
                    <a href="#modal-gastos" data-modal="${e.id_gst}" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                    <a href="#" data-modal="${e.id_gst}" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
                    </td>
                    </tr>`;
                }
            });
            $("#Gastos tbody").html(templateGastos);
        }, "JSON");
    }

    //FUNCION PARA SUMAR GASTOS
    function sumarGastos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "sumarGastos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
        $.post(ruta, obj, function (respuesta) {
            $.each(respuesta, function (i, e) {
                if (e.total == 0 || e.total == "" || e.total == null) {
                    e.total = 0;
                    $('#totalGasto').text("$ " + e.total);
                } else {
                    $('#totalGasto').text("$ " + e.total);
                }
            });
        }, "JSON");
    }

    // Limpiar inputs del modal
    $("#btn-cancela").click(function () {
        $('input[type = text]').val('');
        $('#cant_gst').val('');
        $('input[type=checkbox]').prop("checked", false);
        $('#id_cat').val('0');
        $('input').removeClass('valid');
        $('input').removeClass('invalid');
    });

    //Boton Insertar nuevo gasto
    $(".btn-new").click(function () {
        obj = {
            accion: "insertGasto"
        };
        $('#modal-title').text('Nuevo Gasto');
        $("#btn-form").text("Insertar");
    });

    //Boton Editar
    $("#Gastos").on("click", ".btn-edit", function (e) {
        e.preventDefault();
        let id = $(this).attr("data-modal");
        obj = {
            accion: "getGasto",
            id: id,
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
        $.post(
            ruta,
            obj,
            function (respuesta) {
                $("#nombre_gst").val(respuesta.nombre_gst);
                $("#id_cat").val(respuesta.id_cat);
                $("#cant_gst").val(respuesta.cant_gst);
                $("#desc_gst").val(respuesta.desc_gst);
                $("#fecha_gst").val(respuesta.fecha_gst);

                if (respuesta.recurrente_gst == 1) {
                    $("#recurrente_gst").prop("checked", true);
                } else if (respuesta.recurrente_gst == 0) {
                    $("#recurrente_gst").prop("checked", false);
                }

                obj = {
                    accion: "updateGasto",
                    id: id,
                };
            }, "JSON"
        );
        $('#modal-title').text('Editar Gasto');
        $("#btn-form").text("Editar");
    });


    //Boton Insertar/Editar del Modal
    $("#btn-form").click(function () {

        $("#modal-gastos").find("input").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
            if ($(this).prop("type") == "checkbox") {
                obj[$(this).prop("name")] = $(this).prop("checked");
            }
        });

        $("#modal-gastos").find("select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });

        switch (obj.accion) {
            case "insertGasto":
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                    if (respuesta.status == 0) {
                        swal("¡ERROR!", "Campos vacios", "error");
                    } else if (respuesta.status == 2) {
                        // alert(respuesta.sesion + respuesta.registros);
                        swal("PLAN AGOTADO", "Tu cantidad de Gastos a llegado a su máximo número de registros en el mes seleccionado", "warning").then(() => {
                            location.reload();
                        });
                    } else if(respuesta.status == 3){
                        // alert(respuesta.status);
                        swal("PLAN AGOTADO", "Tu cuenta expira antes que la fecha seleccionada", "warning");
                    }else if (respuesta.status == 1) {
                        swal("Éxito", "Gasto registrado correctamente", "success").then(() => {
                            location.reload();
                        });
                        // alert(respuesta.sesion);
                    }

                }, 'JSON');
                break;

            case 'updateGasto':
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                    if (respuesta.status == 0) {
                        swal('¡ERROR!', 'Campos vacios', 'error');
                    } else if (respuesta.status == 2) {
                        // alert(respuesta.ola);
                        swal("MES AGOTADO", "Tu cantidad de Gastos a llegado a su máximo número de registros en el mes seleccionado", "warning").then(() => {
                            location.reload();
                        });
                    } else if(respuesta.status == 3){
                        // alert(respuesta.status);
                        swal("PLAN AGOTADO", "Tu cuenta expira antes que la fecha seleccionada", "warning");
                    }else if (respuesta.status == 1) {
                        swal('Éxito', 'Gasto editado correctamente', 'success').then(() => {
                            location.reload();
                        });
                    }
                }, 'JSON');
                break;

            default:
                break;

        }
    });
    //BOTON BORRAR GASTO
    $("#Gastos").on("click", ".btn-delete", function (e) {
        let id = $(this).attr("data-modal");
        obj = {
            accion: "deleteGasto",
            gasto: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "El gasto será eliminado",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "Gasto eliminado correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                    }
                }, "JSON");
            }
        });
    });

    //BOTONES ADELANTE Y ATRAS
    $('#left').click(function () {
        date.setMonth(date.getMonth() - 1);
        let MonthN = date.getMonth();
        let Year = date.getFullYear();
        let MonthName = getMonthFromNumber(MonthN);
        let FullDate = MonthName + ', ' + Year;
        $('#fecha_nueva').text(FullDate);
        consultarGastos(MonthN, Year);
        sumarGastos(MonthN, Year);
    });

    $("#right").click(function () {
        date.setMonth(date.getMonth() + 1);
        let MonthN = date.getMonth();
        let Year = date.getFullYear();
        let MonthName = getMonthFromNumber(MonthN);
        let FullDate = MonthName + ', ' + Year;
        $('#fecha_nueva').text(FullDate);
        consultarGastos(MonthN, Year);
        sumarGastos(MonthN, Year);
    });

});