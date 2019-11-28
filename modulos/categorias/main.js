$(document).ready(function(){
    $(".modal").modal();
    let obj = {};
    let editEnable = false;
    $('.insert-new__cat').click(function(){
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

    $('.insertCat').click(function(){
        let nombre_cat = $('#nombre_cat').val();
        obj = {
            "accion": "insertarCategoria",
            "nombre_cat": nombre_cat
        };
        $.post("../../modulos/categorias/funciones.php", obj, function(e){
            console.log(e);
            if(e.status == 1 || e.status == '1'){
                console.log("Correcto");
                swal("Éxito", "Categoría añadida correctamente", "success").then(
                    () => {
                      location.reload();
                    }
                  );
            } else if(e.status == 0){
                swal('¡ERROR!', 'Campo vacio', 'error');
            }
        }, "JSON");
    });
    $('.editedit').click(function(e){
        $("#modal-title").text("Editar Categoría");
        let idc = $(this).data("modalxd");
        e.preventDefault();
        obj = {
            "accion":"uniCat",
            "id":idc
        };
        $.post("../../modulos/categorias/funciones.php",obj,function(r){
            console.log(r);
            $('#nombre_cat').val(r.nombre_cat);
            // $('.insertCat').addClass("editCat");
            // $('.editCat').removeClass("insertCat");
            // $('.editCat').text('Editar');
            $('.editCat').attr("data-catcat", idc);
        }, "JSON");
    });
    $('.btn-edit').click(function(e){
        editEnable = true;
        checkBtnEnable(editEnable);
        // e.preventDefault();
    });
    $('.editCat').click(function(){
        let idc = $('.editCat').data("catcat");
        console.log(idc);
        let nombree = $('#nombre_cat').val();
        console.log(idc,nombree);
        obj = {
            "accion": "editCat",
            "id_cat": idc,
            "nombre_cat": nombree
        };
        console.log(obj);
        $.post("../../modulos/categorias/funciones.php", obj, function(a){
            if(a.status == 1 || a.status == '1'){
                console.log("Bienbien");
                location.reload();
            } else if(e.status == 0){
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
                $.post("../../modulos/categorias/funciones.php", obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "La categoría fue eliminada correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                    } else {
                        errorAlert();
                    }
                }, "JSON"
                );
            }
        });
    });


});

function checkBtnEnable(aaa){
    if(!aaa){
        $('.editCat').hide();
        $('.insertCat').show();
    } else {
        $('.editCat').show();
        $('.insertCat').hide();
    }
}