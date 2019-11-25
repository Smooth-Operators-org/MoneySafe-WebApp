<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'includes/_db.php';
 
 session_start();
 error_reporting(0);
 $id_plan = $_SESSION['plan'];
 $id_usr = $_SESSION['id'];

 if ($_POST) {
     switch ($_POST["accion"]) {
        case 'insertGasto':
            insertGasto();
            break;

        case 'getGasto':
            getGasto($_POST['id']);
            break;
            
		case 'updateGasto':
			updateGasto($_POST['id']);
			break;

        case 'deleteGasto':
            deleteGasto($_POST['gasto']);
            break;

        default:
            # code...
            break;
     }
 }

    function getIduser(){
        global $db;
        $idusr = $db->get("usuarios","id_usr",["correo_usr" => $_POST["varsesion"]]);
        return $idusr;
    }

    function deleteGasto($id){
		global $db;
		$db->delete("gastos", ["id_gst" => $id]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
    }
    
    function insertGasto(){
        global $db, $id_plan, $id_usr;
        $respuesta = [];
        
        if($id_plan == 2){
            $registros = $db->count("gastos","*",["id_usr" => $id_usr]); 
            
        }
        
        $fecha_reg = date("Y-m-d");
        //RECURRENTE
        if($_POST["recurrente_gst"] == "false"){
            $rec = 0;
        }else if($_POST["recurrente_gst"] == "true"){
            $rec = 1;
        }

        //VALIDACION INSERTAR  
        if($_POST["nombre_gst"] == "" || $_POST["id_cat"] == "" || $_POST["cant_gst"] == "" ||  $_POST["desc_gst"] == "" || $_POST["fecha_gst"] == ""){

            $respuesta['status'] = 0;
            
           
        }elseif($id_plan == 2 && $registros >= 7 ){
            // $respuesta['registros'] = $registros;
            // $respuesta['sesion'] = $id_plan;
            $respuesta['status'] = 2;
        }else{
            $newDate = date("Y-m-d", strtotime($_POST["fecha_gst"]));
            $idusuario = getIduser();
            $db->insert("gastos",[
                "nombre_gst" => $_POST["nombre_gst"],
                "id_cat" => $_POST["id_cat"],
                "cant_gst" => $_POST["cant_gst"],
                "desc_gst" => $_POST["desc_gst"],
                "id_usr" => $idusuario,
                "recurrente_gst" => $rec,
                "fecha_gst" => $newDate,
                "fecha_reg" => $fecha_reg

            ]);
            
            $respuesta["status"] = 1;
            // $respuesta["sesion"] = $id_plan;
            
        }

        echo json_encode($respuesta);
    }

    function getGasto($id){
		global $db;
        $gasto = $db->get("gastos", "*", ["id_gst" => $id]);
        $cate = $db->get("categorias","nombre_cat",["id_cat" => $gasto["id_cat"]]);
        
        $respuesta["nombre_gst"] = $gasto["nombre_gst"];
        $respuesta["id_cat"] = $gasto["id_cat"];
        $respuesta["cant_gst"] = $gasto["cant_gst"];
        $respuesta["desc_gst"] = $gasto["desc_gst"];
        $respuesta["recurrente_gst"] = $gasto["recurrente_gst"];
        $respuesta["fecha_gst"] = $gasto["fecha_gst"];
        $respuesta["nombre_cat"] = $cate;
                
        echo json_encode($respuesta);
    }

	function updateGasto($id){
		global $db;
        $respuesta = [];
        
        $fecha_reg = date("Y-m-d");
        if($_POST["recurrente_gst"] == "false"){
            $rec = 0;
        }else if($_POST["recurrente_gst"] == "true"){
            $rec = 1;
        }

        if($_POST["nombre_gst"] == "" || $_POST["id_cat"] == "" || $_POST["cant_gst"] == "" ||  $_POST["desc_gst"] == "" || $_POST["fecha_gst"] == ""){

            $respuesta['status'] = 0;
            
           
        }else{
            $newDate = date("Y-m-d", strtotime($_POST["fecha_gst"]));
            // $idusuario = getIduser();
            $db->update("gastos",[
                "nombre_gst" => $_POST["nombre_gst"],
                "id_cat" => $_POST["id_cat"],
                "cant_gst" => $_POST["cant_gst"],
                "desc_gst" => $_POST["desc_gst"],
                
                "recurrente_gst" => $rec,
                "fecha_gst" => $newDate,
                "fecha_reg" => $fecha_reg

            ], ["id_gst" => $id]);
            
            $respuesta["status"] = 1;
            // $respuesta["sesion"] = $idusr;
            
        }

        echo json_encode($respuesta);
	}
   

?>