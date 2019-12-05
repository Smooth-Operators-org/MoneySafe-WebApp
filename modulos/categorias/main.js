$(document).ready(function () {
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

    $('.sidenav').sidenav();
    $('.modal').modal();
    $('.tooltipped').tooltip();
    let obj = {};
    let editEnable = false;
    $('.insert-new__cat').click(function () {
        editEnable = false;
        checkBtnEnable(editEnable);
        $('#nombre_cat').val('');
        $("#modal-title").text("Nueva Categoría");
    });

    $("#btn-cancel").click(function () {
        $('input[type = text]').val('');
        $('input').removeClass('valid');
        $('input').removeClass('invalid');
    });

    $('.insertCat').click(function () {
        let nombre_cat = $('#nombre_cat').val();
        obj = {
            "accion": "insertarCategoria",
            "nombre_cat": nombre_cat
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/categorias/funciones.php";
        $.post(ruta, obj, function (e) {
            console.log(e);
            if (e.status == 1 || e.status == '1') {
                console.log("Correcto");
                swal("Éxito", "Categoría añadida correctamente", "success").then(
                    () => {
                        location.reload();
                    }
                );
            } else if (e.status == 0) {
                swal('¡ERROR!', 'Campo vacio', 'error');
            } else if (e.status == 2) {
                swal('¡PLAN AGOTADO!', 'Tu cantidad de registros se ha agotado', 'warning').then(
                    () => {
                        location.reload();
                    });
            }
        }, "JSON");
    });
    $('.editedit').click(function (e) {
        $("#modal-title").text("Editar Categoría");
        let idc = $(this).data("modalxd");
        e.preventDefault();
        obj = {
            "accion": "uniCat",
            "id": idc
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/categorias/funciones.php";
        $.post(ruta, obj, function (r) {
            console.log(r);
            $('#nombre_cat').val(r.nombre_cat);
            // $('.insertCat').addClass("editCat");
            // $('.editCat').removeClass("insertCat");
            // $('.editCat').text('Editar');
            $('.editCat').attr("data-catcat", idc);
        }, "JSON");
    });
    $('.btn-edit').click(function (e) {
        editEnable = true;
        checkBtnEnable(editEnable);
        // e.preventDefault();
    });
    $('.editCat').click(function () {
        let idc = $('.editCat').data("catcat");
        console.log(idc);
        let nombree = $('#nombre_cat').val();
        console.log(idc, nombree);
        obj = {
            "accion": "editCat",
            "id_cat": idc,
            "nombre_cat": nombree
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/categorias/funciones.php";
        $.post(ruta, obj, function (a) {
            if (a.status == 1 || a.status == '1') {
                console.log("Bienbien");
                location.reload();
            } else if (e.status == 0) {
                swal('¡ERROR!', 'Campo vacio', 'error');
            }
        }, "JSON");
    });

    $(".btn-delete").click(function () {
        let id = $(this).data("modalxd");
        obj = {
            accion: "deleteCat",
            categoria: id
        };
        swal({
            title: "¿Estás seguro?",
            text: "La categoría será eliminada",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/categorias/funciones.php";
                $.post(ruta, obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "La categoría fue eliminada correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                    } else {
                        errorAlert();
                    }
                }, "JSON");
            }
        });
    });


});

function checkBtnEnable(aaa) {
    if (!aaa) {
        $('.editCat').hide();
        $('.insertCat').show();
    } else {
        $('.editCat').show();
        $('.insertCat').hide();
    }
}