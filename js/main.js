$(document).ready(function () {
    //MATERIALIZE
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();

    //VARIABLES
    let obj = {};
    var date = new Date();
    let MonthN = date.getMonth();
    let Year = date.getFullYear();
    let MonthName = getMonthFromNumber(MonthN);
    let FullDate = MonthName + ', ' + Year;
    $('#fecha_nueva').text(FullDate);

    //EJECUTAR FUNCIONES
    consultarGastos(MonthN, Year);
    consultarIngresos(MonthN, Year);
    sumarGastos(MonthN, Year);
    sumarIngresos(MonthN, Year);
    sumaGeneral(MonthN, Year);

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
                templateGastos += `
                    <tr>
                    <td>${e.nombre_gst}</td>
                    <td>${e.nombre_cat}</td>
                    <td>${"$ "+e.cant_gst}</td>
                    </tr>`;
            });
            $("#tabla_gastos tbody").html(templateGastos);
        }, "JSON");
    }

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
                templateIngresos += `
                    <tr>
                    <td>${e.nombre_ing}</td>
                    <td>${"$ "+e.cant_ing}</td>
                    </tr>`;
            });
            $("#tabla_ingresos tbody").html(templateIngresos);
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
                $("#totalG").val(e.total);
            });
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
                $("#totalI").val(e.total);
            });
        }, "JSON");
    }

    function sumaGeneral(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "sumarGeneral",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/gastos/consultas.php";
        $.post(ruta, obj, function (respuesta) {
            if (respuesta.total > 0) {
                $("#cardTotal").removeClass('grey');
                $("#cardTotal").removeClass('red');
                $("#cardTotal").addClass('green');
            }else if(respuesta.total < 0){
                $("#cardTotal").removeClass('grey');
                $("#cardTotal").removeClass('green');
                $("#cardTotal").addClass('red');
            }else if(respuesta.total == 0){
                $("#cardTotal").removeClass('red');
                $("#cardTotal").removeClass('green');
                $("#cardTotal").addClass('grey');
            }
            $('#totalGeneral').text("$ " +respuesta.total);
        }, "JSON");
    }

    $('#left').click(function () {
        date.setMonth(date.getMonth() - 1);
        let MonthN = date.getMonth();
        let Year = date.getFullYear();
        let MonthName = getMonthFromNumber(MonthN);
        let FullDate = MonthName + ', ' + Year;
        $('#fecha_nueva').text(FullDate);
        consultarGastos(MonthN, Year);
        consultarIngresos(MonthN, Year);
        sumarGastos(MonthN, Year);
        sumarIngresos(MonthN, Year);
        sumaGeneral(MonthN, Year);
    });

    $("#right").click(function () {
        date.setMonth(date.getMonth() + 1);
        let MonthN = date.getMonth();
        let Year = date.getFullYear();
        let MonthName = getMonthFromNumber(MonthN);
        let FullDate = MonthName + ', ' + Year;
        $('#fecha_nueva').text(FullDate);
        consultarGastos(MonthN, Year);
        consultarIngresos(MonthN, Year);
        sumarGastos(MonthN, Year);
        sumarIngresos(MonthN, Year);
        sumaGeneral(MonthN, Year);
    });

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

    //FUNCION PARA OBTENER Y EDITAR DATOS DE USUARIO
    $('.modal-info').click(function () {
        let id = $(this).attr('data');
        obj = {
            accion: 'getData',
            id: id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/includes/consultas.php";
        $.post(ruta, obj, function (respuesta) {
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
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/includes/consultas.php";
                $.post(ruta, obj, function (respuesta) {
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
});