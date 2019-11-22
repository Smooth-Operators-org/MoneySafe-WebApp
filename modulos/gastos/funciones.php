<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/_db.php';
 //session_start();
 //error_reporting(0);
 //$varsesion = $_SESSION['email'];
 if ($_POST) {
     switch ($_POST["accion"]) {
        case 'insertGasto':
            insertGasto();
        break;

        case 'getGasto':
            getGasto($_POST['gasto']);
            break;
            
		case 'updateGasto':
			updateGasto($_POST['gasto']);
			break;

        case 'deleteGasto':
            deleteGasto($_POST['gasto']);
            break;

        default:
            # code...
            break;
     }
 }

 function insertGasto(){
	global $db;
	$respuesta = [];
	$nombre = $_POST['nombre'];
	$status = $_POST['status'];
	
	echo json_encode($respuesta);
}
    function getGasto($id){
		global $db;
        $gasto = $db->get("gastos", "*", ["id" => $id]);
        $respuesta["nombre"] = $gasto["nombre"];
        $respuesta["status"] = $gasto["status"];
        echo json_encode($respuesta);
    }

	function updateGasto($id){
		global $db;
		//$fecha= strftime("%y-%m-%d %H:%M:%S");
		$nombre = $_POST['nombre'];
		$status = $_POST['status'];
		
		echo json_encode($respuesta);
	}


	function deleteGasto($id){
		global $db;
		$db->delete("gastos", ["id_gst" => $id]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
    }
    
?>