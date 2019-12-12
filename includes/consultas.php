<?php
 require_once '_db.php';
 
 session_start();
 error_reporting(0);
//  $id_plan = $_SESSION['plan'];
//  $id_usr = $_SESSION['id'];

 if ($_POST) {
     switch ($_POST["accion"]) {

        case 'getData':
            getData($_POST['id']);
            break;

        case 'updateData':
            updateData($_POST['id']);
            break;
        
        default:
            # code...
            break;
     }
 }

function getData($id){
    global $db;
    $usuario = $db->get("usuarios", "*", ["id_usr" => $id]);
    $respuesta["nombre_usr"] = $usuario["nombre_usr"];
    $respuesta["plan_deseado"] = $usuario["plan_deseado"];
    echo json_encode($respuesta);
}

function updateData($id){
    global $db;
    if ($_POST['nombre_usr_info'] == "") {
        $respuesta["status"] = 0;
    }else{
        $db->update("usuarios", [
            "nombre_usr" => $_POST['nombre_usr_info'],
            "plan_deseado" => $_POST['id_plan']
        ], [
            "id_usr" => $id
        ]);
        $respuesta["status"] = 1;
        $_SESSION['nombre'] = $_POST['nombre_usr_info'];
    }
    echo json_encode($respuesta);
}
?>