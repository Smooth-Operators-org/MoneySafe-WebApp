$(document).ready(function () {
    // Inicializar Funciones Materialize
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();

    var obj = {};

    // Limpiar inputs del modal
    $("#btn-cancel").click(function () {
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
        $('#modal-title').text('Nuevo Gasto')
        $("#btn-form").text("Insertar");
    });

    //Boton Editar
    $(".btn-edit").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "getGasto",
            id: id,
        };
        $.post(
            "/modulos/gastos/consultas.php",
            obj,
            function (respuesta) {
                $("#nombre_gst").val(respuesta.nombre_gst);
                $("#id_cat").val(respuesta.id_cat);
                $("#cant_gst").val(respuesta.cant_gst);
                $("#desc_gst").val(respuesta.desc_gst);
                $("#fecha_gst").val(respuesta.fecha_gst);

                if (respuesta.recurrente_gst == 1) {
                    $("#recurrente_gst").prop("checked", true);
                } else if(respuesta.recurrente_gst == 0){
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
    $("#btn-form").click(function(){

        $("#modal-gastos").find("input").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
            if ($(this).prop("type") == "checkbox"){
                obj[$(this).prop("name")] = $(this).prop("checked");
            }
        });

        $("#modal-gastos").find("select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });
        
        switch (obj.accion) {
            
            case "insertGasto":
                $.post('/modulos/gastos/consultas.php', obj, function(respuesta){
                        if (respuesta.status == 0) {
                            swal("¡ERROR!", "Campos vacios", "error");
                        } else if(respuesta.status == 2){
                            // alert(respuesta.sesion + respuesta.registros);
                            swal("PLAN AGOTADO", "Tu cantidad de Gastos a llegado a su máximo número de registros", "warning").then(() => {location.reload();});
                        } else if (respuesta.status == 1) {
                            swal("Éxito", "Gasto registrado correctamente", "success").then(() => {
                                location.reload();
                            });
                            // alert(respuesta.sesion);
                        } 
                      
                    }, 'JSON'
                );
                break;

                case 'updateGasto':
                    $.post('/modulos/gastos/consultas.php', obj, function (respuesta) {
                            if (respuesta.status == 0) {
                                swal('¡ERROR!', 'Campos vacios', 'error');
                            } else if (respuesta.status == 1) {
                                swal('Éxito', 'Gasto editado correctamente', 'success').then(() => {
                                    location.reload();
                                });
                            } 
                        },'JSON'
                    );
                    break;
    
                default:
                break;

        }
    });

    //BOTON BORRAR GASTO
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
                $.post("/modulos/gastos/consultas.php", obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "Gasto eliminado correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                    }
                }, "JSON");
            }
        });
    });

});