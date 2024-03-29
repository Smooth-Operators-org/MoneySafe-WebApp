$(document).ready(function(){
    // INICIALIZAR FUNCIONES MATERIALIZE PARA LOS ESTILOS Y ACCIONES
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();

    var obj = {};

    //BOTON-CANCEL-MODAL
    //Debes de limpiar todos los inputs que utilices!
    $('#btn-cancel-modal').click(function (){
        $('input').removeClass('valid');
        $('input').removeClass('invalid');
        $('input[type = checkbox]').prop('checked', false);
        $('input[type = text]').val('');
        $('input[type = email]').val('');
        $('input[type = password]').val('');
        $('#id_plan').val('0');
        $('#id_niv').val('0');
    });

    $('.btn-new').click(function (){
        obj = {
            accion : 'insertUsuario'
        };
        $('#modal-title').text('Nuevo Usuario')
        $('#btn-form-modal').text('Insertar')
    });

    $('.btn-edit').click(function (){
        let id = $(this).attr('data-modal');
        obj = {
            accion : 'getUsuario',
            id : id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/modulos/usuarios/consultas.php";
        $.post(ruta, obj, function (respuesta) {
                $('#nombre_usr').val(respuesta.nombre_usr);
                $('#correo_usr').val(respuesta.correo_usr);
                $('#password_usr').val(respuesta.password_usr);
                if (respuesta.id_niv == 1) {
                    $('#id_niv').val('1');
                } else if(respuesta.id_niv == 2){
                    $('#id_niv').val('2');
                }
                $('#id_plan').val(respuesta.id_plan);
                if (respuesta.status_usr == 1) {
                    $("#status_usr").prop("checked", true);
                } else if(respuesta.status_usr == 0){
                    $("#status_usr").prop("checked", false);
                }
                obj = {
                    accion : 'updateUsuario',
                    id : id
                };
        },'JSON');
        $('#modal-title').text('Editar Usuario')
        $('#btn-form-modal').text('Editar')
    });

    $('.btn-delete').click(function () {
        let id = $(this).attr('data-modal');
        obj = {
            accion : 'deleteUsuario',
            id : id
        };
        swal({
            title: '¿Estás seguro?',
            text: 'El usuario será eliminado',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/usuarios/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                        if (respuesta.status == 1) {
                            swal('Éxito', 'Usuario eliminado correctamente', 'success').then((willDelete) => {
                                location.reload();
                            });
                        }
                    },'JSON'
                );
            }
        });
    });

    $('.modal-info').click(function (){
        let id = $(this).attr('data');
        obj = {
            accion : 'getData',
            id : id
        };
        var hostName = $(location).attr('hostname');
        var http = "http://";
        var direc = "/MoneySafe-WebApp";
        var ruta = http+hostName+direc+"/includes/consultas.php";
        $.post(ruta, obj , function (respuesta) {
                $('#nombre_usr_info').val(respuesta.nombre_usr);
                if (respuesta.plan_deseado == "0" || respuesta.plan_deseado == 0) {
                    $('#id_plan').val('0');
                }else{
                    $('#id_plan').val(respuesta.plan_deseado);
                }
                obj = {
                    accion : 'updateData',
                    id : id
                };
        },'JSON');
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
                    },'JSON');
                break;
            default:
                break;
        }
    });

    $('#btn-form-modal').click(function () {
        $('#modal-usuarios').find('input').map(function (i, e) {
                obj[$(this).prop('name')] = $(this).val();
                if ($(this).prop("type") == "checkbox"){
                    obj[$(this).prop("name")] = $(this).prop("checked");
                }
        });
        $("#modal-usuarios").find("select").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });
        switch (obj.accion) {

            case 'insertUsuario':
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/usuarios/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                        if (respuesta.status == 0) {
                            swal('¡ERROR!', 'Campos vacios', 'error');
                        } else if (respuesta.status == 2) {
                            swal('¡ERROR!', 'Inserta una derección de email valida', 'error');
                        } else if (respuesta.status == 3) {
                            swal("¡ERROR!", "Este email ya ha sido registrado", "error");
                        } else if (respuesta.status == 1) {
                            swal("Éxito", "Usuario registrado correctamente", "success").then(
                                () => {
                                  location.reload();
                            });
                        }
                    },'JSON'
                );
                break;

            case 'updateUsuario':
                var hostName = $(location).attr('hostname');
                var http = "http://";
                var direc = "/MoneySafe-WebApp";
                var ruta = http+hostName+direc+"/modulos/usuarios/consultas.php";
                $.post(ruta, obj, function (respuesta) {
                        if (respuesta.status == 0) {
                            swal('¡ERROR!', 'Campos vacios', 'error');
                        } else if (respuesta.status == 1) {
                            swal('Éxito', 'Usuario editado correctamente', 'success').then(() => {
                                location.reload();
                            });
                        } else if (respuesta.status == 2) {
                            swal('¡ERROR!', 'Inserta una derección de email valida', 'error');
                        }
                    },'JSON'
                );
                break;

            default:
                break;
        
        }
    });
});