$(document).ready(function(){
    // Inicializar Funciones Materialize
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();

    var obj = {};

    // Limpiar inputs del modal
    $("#btn-cancel").click(function(){  
        $('input').val('');
        $('input[type=checkbox]'). prop("checked", false);
    });

    $(".btn-delete").click(function () {
        let id = $(this).attr("data");
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
                $.post("/modulos/gastos/funciones.php", obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "Gasto eliminado correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                    }
                }, "JSON"
                );
            }
        });
    });

});

