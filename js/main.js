$(document).ready(function(){
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    let obj = {};

    $('#left').click(function(){
        // alert("izquierdo");
        let fecha_actual = $(this).attr('data');
        obj = {
            accion: "atras",
            fecha_actual: fecha_actual
        };
        $.post(
            "includes/consultas.php", obj, function(respuesta){
                console.log(respuesta);
            }, 'JSON'
        );
        // alert(fecha_actual);
    });

    $("#right").click(function(){
        // alert("derecho");
        let fecha_actual = $(this).attr('data');
        obj = {
            accion: "adelante",
            fecha_actual: fecha_actual
        };
        $.post(
            "includes/consultas.php", obj, function(respuesta){
                console.log(respuesta);
            }, 'JSON'
        );
        // alert(fecha_actual);
    
    });
});