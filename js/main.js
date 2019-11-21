$(document).ready(function(){
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    let obj = {};
    $('#insertCat').click(function(){
        let nombre_cat = $('#nombre_cat').val();
        obj = {
            "accion": "insertarCategoria",
            "nombre_cat": nombre_cat
        };
        $.post("../includes/funciones.php", obj, function(e){
            console.log(e);
            if(e.status == 1 || e.status == '1'){
                console.log("Correcto");
                swal("Éxito", "Categoría añadida correctamente", "success").then(
                    () => {
                      location.reload();
                    }
                  );
            } else {
                console.log("Incorrecto");
            }
        }, "JSON");
    });
});