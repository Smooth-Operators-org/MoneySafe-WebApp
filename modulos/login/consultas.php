<?php
	require_once '../../includes/_db.php';
	require '../../vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	if ($_POST) {
		switch ($_POST["accion"]) {
			case 'login':
				login();
				break;
			
			case 'register':
				register();
				break;
			default:
				break;
		}
	}

	function dias_restantes($fecha_baja) {
		$fecha_actual = date("Y-m-d");    
		$s = strtotime($fecha_baja)-strtotime($fecha_actual);  
		$d = intval($s/86400);  
		$diferencia = $d;  
		return $diferencia;  
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
    
	function login(){
		global $db;
		$respuesta = [];
		if ($_POST['email'] !=  "") {	
			$usuario = $db->get("usuarios", "*", ["correo_usr" => $_POST['email']]);
			if ($usuario) {
				if ($usuario = $db->get("usuarios", "*", ["AND" => ["correo_usr" => $_POST['email'], "status_usr"=> 0]])) {
					$respuesta["status"] = 6;
				}elseif ($usuario = $db->get("usuarios", "*", ["AND" => ["correo_usr" => $_POST['email'], "password_usr"=> $_POST['password']]])) {
					session_start();
					error_reporting(0);
					$_SESSION['id'] = $usuario["id_usr"];
					$_SESSION['nombre'] = $usuario["nombre_usr"];
					$_SESSION['email'] = $usuario["correo_usr"];
					$_SESSION['status'] = $usuario["status_usr"];
					$_SESSION['nivel'] = $usuario["id_niv"];
					$_SESSION['plan'] = $usuario["id_plan"];
					$_SESSION['fecha_alta'] = $usuario["fecha_alta"];
					$_SESSION['fecha_baja'] = $usuario["fecha_baja"];
					$_SESSION['days'] = dias_restantes($usuario["fecha_baja"]);
					$varsesion= $_SESSION['email'];
					$respuesta["status"] = 3;
					$respuesta["nivelusr"] = $_SESSION['nivel'];
					$respuesta["days"] = $_SESSION['days'];
					$respuesta["plan"] = $_SESSION['plan'];
				}else{
					$respuesta["status"] = 2;
				}
			}else{
				$respuesta["status"] = 4;
			}
		
		}else{
			$respuesta["status"] = 5;
		}
		
		echo json_encode($respuesta);
    }
    
	function register(){
		global $db;
		$respuesta = [];
		$duplicate = false;

			if ($_POST["password_usr"] != $_POST["re_password_usr"]) {
				$respuesta["status"] = 3;
			}else if ($_POST["correo_usr"] != filter_var($_POST["correo_usr"], FILTER_VALIDATE_EMAIL)) {
				$respuesta["status"] = 4;
			}else if ($_POST["nombre_usr"]  != ""  && $_POST["correo_usr"]  != ""  && $_POST["password_usr"]  != ""  && $_POST["re_password_usr"]  != "" &&  $_POST["id_plan"]  != "") {
				$key = generarKey(10);
                $duplicate = valCorreo("usuarios", "correo_usr", $_POST["correo_usr"]);
					if (!$duplicate) {
                		$usuarios = $db->insert('usuarios',[
                    	"nombre_usr" => $_POST["nombre_usr"],
                    	"correo_usr" => $_POST["correo_usr"],
                    	"password_usr" => $_POST["password_usr"],
                    	"key_usr" => $key,
                    	"status_usr" => 0,
                    	"id_plan" => $_POST["id_plan"],
                        "id_niv" => "2",
                        "fecha_alta" => "0",
                        "fecha_baja" => "0"
						]);
                    		if ($usuarios) {
								$email = $db->get("usuarios", "*", [
									"correo_usr" => $_POST["correo_usr"]
								]);
								$email_to = $email["correo_usr"];
								$email_from = "mail@smoothoperators.com.mx";
								$from_name = "Money-Safe";
								$subject = "Activación de cuenta Money Safe";
								$body = "Bienvenido a Money-Safe, en unos momentos uno de nuestros ejecutivos activará tu cuenta. Muchas Gracias.";
								global $error;
								$mail = new PHPMailer();
								$mail->CharSet = "utf-8";
								$mail->IsSMTP(); 
								$mail->SMTPDebug = 0;  
								$mail->SMTPAuth = true;  
								$mail->SMTPSecure = 'ssl'; 
								$mail->Host = 'smtp.gmail.com';
								$mail->Port = 465; 
								$mail->Username = 'mail.smoothoperators@gmail.com';  
								$mail->Password = 'Goodluck13';
								$mail->SetFrom($email_from, $from_name);
								$mail->Subject = $subject;
								$mail->Body = $body;
								$mail->IsHTML(true);
								$mail->AddAddress($email_to);
									if(!$mail->Send()) {
										echo "Error";
									} else {
										$respuesta["status"] = 1;
									}
                    		} else {
                        		$respuesta["status"] = 0;
                    	    }
                	} else {
                    	$respuesta["status"] = 2;
					}  
    		} else {
        		$respuesta["status"] = 0;
			}
		echo json_encode($respuesta);
	}
?>