<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
	// session_start();
    // error_reporting(0);
    // $varsesion = $_SESSION['email'];
	if ($_POST) {
		switch ($_POST["accion"]) {
			case 'insertUsuario':
				insertUsuario();
				break;
			
			case 'getUsuario':
				getUsuario($_POST['id']);
				break;
			case 'updateUsuario':
				updateUsuario($_POST['id']);
				break;
			case 'deleteUsuario':
				deleteUsuario($_POST['id']);
				break;
			default:
				# code...
				break;
		}
    }

    function generarKey($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    function valCorreo($tabla, $campo, $param){
        global $db;
        $correos = $db->select($tabla, $campo);
        foreach ($correos as $correo) {
            if($correo == $param){
                $duplicate = true;
                return $duplicate;
            }
        }
    }
    
	function insertUsuario(){
        global $db;
        $respuesta = [];
        $duplicate = false;
            if ($_POST["nombre_usr"] == "" || $_POST["correo_usr"] == "" || $_POST["password_usr"] == "" || $_POST["id_niv"] == "" || $_POST["id_plan"] == "" || $_POST["status_usr"] == "") {
                $respuesta["status"] = 0;
            }else if ( $_POST["correo_usr"] != filter_var($_POST["correo_usr"], FILTER_VALIDATE_EMAIL)) {
                $respuesta["status"] = 2;
            }else{
                if ($_POST['id_plan'] == 1 && $_POST['status_usr'] == "true") {
                    $status = 1;
                    $fecha_alta = date('Y-m-d');
                    $duracion = 15;
                    $fecha_baja = strtotime ('+'.$duracion.'day');
                    $fecha_baja = date('Y-m-d', $fecha_baja);
                }else if ($_POST['id_plan'] > 1 && $_POST['status_usr'] == "true") {
                    $status = 1;
                    $fecha_alta = date('Y-m-d');
                    $duracion = 365;
                    $fecha_baja = strtotime ('+'.$duracion.'day');
                    $fecha_baja = date('Y-m-d', $fecha_baja);
                }else if ($_POST['id_plan'] == 1 && $_POST['status_usr'] == "false") {
                    $status = 0;
                    $fecha_alta = "00-00-00";
                    $fecha_baja = "00-00-00";
                }else if ($_POST['id_plan'] > 1 && $_POST['status_usr'] == "false") {
                    $status = 0;
                    $fecha_alta = "00-00-00";
                    $fecha_baja = "00-00-00";
                }
                $key = generarKey(10);
                $duplicate = valCorreo("usuarios", "correo_usr", $_POST["correo_usr"]);
                if (!$duplicate) {
                    $usuarios = $db->insert('usuarios',[
                    "nombre_usr" => $_POST["nombre_usr"],
                    "correo_usr" => $_POST["correo_usr"],
                    "password_usr" => $_POST["password_usr"],
                    "key_usr" => $key,
                    "status_usr" => $status,
                    "id_plan" => $_POST["id_plan"],
                    "id_niv" => $_POST["id_niv"],
                    "fecha_alta" => $fecha_alta,
                    "fecha_baja" => $fecha_baja
                    ]);
                    $respuesta["status"] = 1;
                }else{
                    $respuesta["status"] = 3;
                }
            }
        echo json_encode($respuesta);
    }
    
	function getUsuario($id){
		global $db;
		$usuario = $db->get("usuarios", "*", ["id_usr" => $id]);
        $respuesta["nombre_usr"] = $usuario["nombre_usr"];
        $respuesta["correo_usr"] = $usuario["correo_usr"];
        $respuesta["password_usr"] = $usuario["password_usr"];
        $respuesta["id_niv"] = $usuario["id_niv"];
        $respuesta["id_plan"] = $usuario["id_plan"];
        $respuesta["status_usr"] = $usuario["status_usr"];
		echo json_encode($respuesta);
    }
    
	function updateUsuario($id){
		global $db;
        $respuesta = [];
        $duplicate = false;
            if ($_POST["nombre_usr"] == "" || $_POST["correo_usr"] == "" || $_POST["password_usr"] == "" || $_POST["id_niv"] == "" || $_POST["id_plan"] == "" || $_POST["status_usr"] == "") {
                $respuesta["status"] = 0;
            }else if ( $_POST["correo_usr"] != filter_var($_POST["correo_usr"], FILTER_VALIDATE_EMAIL)) {
                $respuesta["status"] = 2;
            }else{
                if ($_POST['id_plan'] == 1 && $_POST['status_usr'] == "true") {
                    $status = 1;
                    $fecha_alta = date('Y-m-d');
                    $duracion = 15;
                    $fecha_baja = strtotime ('+'.$duracion.'day');
                    $fecha_baja = date('Y-m-d', $fecha_baja);
                }else if ($_POST['id_plan'] > 1 && $_POST['status_usr'] == "true") {
                    $status = 1;
                    $fecha_alta = date('Y-m-d');
                    $duracion = 365;
                    $fecha_baja = strtotime ('+'.$duracion.'day');
                    $fecha_baja = date('Y-m-d', $fecha_baja);
                }else if ($_POST['id_plan'] == 1 && $_POST['status_usr'] == "false") {
                    $status = 0;
                    $fecha_alta = "00-00-00";
                    $fecha_baja = "00-00-00";
                }else if ($_POST['id_plan'] > 1 && $_POST['status_usr'] == "false") {
                    $status = 0;
                    $fecha_alta = "00-00-00";
                    $fecha_baja = "00-00-00";
                }
                $db->update("usuarios", [
                    "nombre_usr" => $_POST['nombre_usr'],
                    "correo_usr" => $_POST['correo_usr'],
                    "password_usr" => $_POST['password_usr'],
                    "status_usr" => $status,
                    "id_plan" => $_POST['id_plan'],
                    "id_niv" => $_POST['id_niv'],
                    "fecha_alta" => $fecha_alta,
                    "fecha_baja" => $fecha_baja
                ], [
                    "id_usr" => $id
                ]);
                $respuesta["status"] = 1;
            }
		echo json_encode($respuesta);
	}
	
	function deleteUsuario($id){
		global $db;
		// $fecha= strftime("%y-%m-%d %H:%M:%S");
		$db->delete("usuarios", ["id_usr" => $id]);
		// $varsesion= $_SESSION['email'];
		// $db->insert("logs",["id_logs"=>"", "mensaje"=>"el usuario $varsesion elimino en el modulo Entradas", "fecha_hora"=>$fecha]);
		$respuesta["status"] = 1;
		echo json_encode($respuesta);
	}
?>