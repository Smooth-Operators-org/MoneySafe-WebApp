$(document).ready(function () {
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();

    let obj = {};
    var date = new Date();
    let MonthN = date.getMonth();
    let Year = date.getFullYear();
    let MonthName = getMonthFromNumber(MonthN);
    let FullDate = MonthName + ', ' + Year;
    $('#fecha_nueva').text(FullDate);

    consultarGastos(MonthN, Year);
    consultarIngresos(MonthN, Year);
    sumarGastos(MonthN, Year);
    sumarIngresos(MonthN, Year);
    totalGasto(totalGasto);
    totalIngreso(totalIngreso);
    
    //FUNCION PARA CONSULTAR A LA BD
    function consultarGastos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "getDataGastos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        $.post("includes/consultas.php", obj, function (respuesta) {
            let templateGastos = ``;
            $.each(respuesta, function (i, e) {
                templateGastos += `
                    <tr>
                    <td>${e.nombre_gst}</td>
                    <td>${e.id_cat}</td>
                    <td>${"$ "+e.cant_gst}</td>
                    </tr>`;
            });
            $("#Gastos tbody").html(templateGastos);
        }, "JSON");
    }

    function consultarIngresos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "getDataIngresos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        $.post("includes/consultas.php", obj, function (respuesta) {
            let templateIngresos = ``;
            $.each(respuesta, function (i, e) {
                templateIngresos += `
                    <tr>
                    <td>${e.nombre_ing}</td>
                    <td>${"$ "+e.cant_ing}</td>
                    </tr>`;
            });
            $("#Ingresos tbody").html(templateIngresos);
        }, "JSON");
    }

    function sumarGastos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "sumarGastos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        $.post("includes/consultas.php", obj, function (respuesta) {
            $.each(respuesta, function (i, e) {
                if (e.total == 0 || e.total == "" || e.total == null) {
                    e.total = 0;
                    $('#totalGasto').text("$ " + e.total);
                } else {
                    $('#totalGasto').text("$ " + e.total);
                }
                totalGasto(e.total);
            });
        }, "JSON");
    }

    function sumarIngresos(MonthN, Year) {
        let id = $(".modal-info").attr('data');
        let obj = {
            "accion": "sumarIngresos",
            "month": MonthN,
            "year": Year,
            "id": id
        };
        $.post("includes/consultas.php", obj, function (respuesta) {
            $.each(respuesta, function (i, e) {
                if (e.total == 0 || e.total == "" || e.total == null) {
                    e.total = 0;
                    $('#totalIngreso').text("$ " + e.total);                  
                } else {
                    $('#totalIngreso').text("$ " + e.total);
                }
                totalIngreso(e.total); 
            });
        }, "JSON");
    }

    function totalGasto(total) {
        $('#totalG').val(total);
        let g = $('#totalG').val();
        console.log("Gastos"+g);
    }

    function totalIngreso(total) {
        $('#totalI').val(total);
        let i = $('#totalI').val();
        console.log("Ingresos"+i);
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

    $('.modal-info').click(function () {
        let id = $(this).attr('data');
        obj = {
            accion: 'getData',
            id: id
        };
        $.post('includes/consultas.php', obj, function (respuesta) {
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
                $.post('includes/consultas.php', obj, function (respuesta) {
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