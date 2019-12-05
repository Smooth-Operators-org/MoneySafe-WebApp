<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/_db.php';
session_start();
error_reporting(0);
$id_plan = $_SESSION['plan'];
$id_usr = $_SESSION['id'];
$fecha_baja = $_SESSION['fecha_baja'];

if ($_POST) {
    switch ($_POST["accion"]) {
        case 'insertIngreso':
            insertIngreso();
            break;
        case 'getIngreso':
            getIngreso($_POST['id']);
            break;
        case 'updateIngreso':
            updateIngreso($_POST['id']);
            break;
        case 'deleteIngreso':
            deleteIngreso($_POST['id']);
            break;
        default:
            # code...
            break;
    }
}

function insertIngreso()
{
    global $db, $id_plan, $id_usr, $fecha_baja;
    $respuesta = [];

    $fecha_reg = date("Y-m-d");
    $newDate = date("Y-m-d", strtotime($_POST["fecha_ing"]));
    $mes = date("m", strtotime($_POST['fecha_ing']));
    $anio = date("Y", strtotime($_POST['fecha_ing']));
    $mesBj = date("m", strtotime($fecha_baja));
    $anioBJ = date("Y", strtotime($fecha_baja));

    if($id_plan == 2){
        $registros = $db->query("SELECT * FROM ingresos WHERE <id_usr> = $id_usr AND MONTH(<fecha_ing>) = $mes AND YEAR(<fecha_ing>) = $anio")->fetchAll();
        $poderdeHeeman = count($registros);
    }

    if ($_POST["recurrente_ing"] == "false" || $_POST["recurrente_ing"] == "") {
        $recurrente = 0;
    } elseif ($_POST["recurrente_ing"] == "true") {
        $recurrente = 1;
    }

    if ($_POST["nombre_ing"] == "" || $_POST["cant_ing"] == "" || $_POST["desc_ing"] == "" || $_POST["fecha_ing"] == "") {
        $respuesta["status"] = 0;
    } elseif($anio > $anioBJ){
        // echo $anio. $anioBJ;
        $respuesta['status'] = 3; 
    }elseif($recurrente == 1 ){
        $i = 0;
        $meses = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $anios = [$anio , $anioBJ];

        if($anio < $anioBJ){
            for($j = 0; $j <= 1; $j ++){
                if($j == 0){
                    for($i = $mes-1; $i <= $mesBj-1; $i++){
                        // echo " anio: ". $anios[$j];  
                        // echo " mes: ". $meses[$i]. "<br>";
                        // $fecha_rec = date("Y-m-d", strtotime("$anios[$j] + $meses[$i] + 02"));
                        $fecha_rec = $anios[$j].'-'.$meses[$i].'-'.'02';
                        
                        // echo $fecha_rec."<br>";
                        $db->insert("ingresos", [
                            "nombre_ing" => $_POST['nombre_ing'],
                            "cant_ing" => $_POST['cant_ing'],
                            "desc_ing" => $_POST['desc_ing'],
                            "id_usr" => $id_usr,
                            "recurrente_ing" => $recurrente,
                            "fecha_ing" => $fecha_rec,
                            "fecha_reg" => $fecha_reg,
                        ]);
                    }  
                }else if($j == 1){
                    for($i = 0; $i <= $mesBj-1; $i++){
                        // echo " anio: ". $anios[$j];  
                        // echo " mes: ". $meses[$i]. "<br>";
                        $fecha_rec = $anios[$j].'-'.$meses[$i].'-'.'02';
                        $db->insert("ingresos", [
                            "nombre_ing" => $_POST['nombre_ing'],
                            "cant_ing" => $_POST['cant_ing'],
                            "desc_ing" => $_POST['desc_ing'],
                            "id_usr" => $id_usr,
                            "recurrente_ing" => $recurrente,
                            "fecha_ing" => $fecha_rec,
                            "fecha_reg" => $fecha_reg,
                        ]);
                        
                        //  echo $fecha_rec."<br>";
                    }
                }
            }
            
        }else if($anio == $anioBJ){
            $j = 1;
                for($i = $mes-1; $i <= $mesBj-1; $i++){
                    $fecha_rec = $anios[$j].'-'.$meses[$i].'-'.'02';
                    $db->insert("ingresos", [
                        "nombre_ing" => $_POST['nombre_ing'],
                        "cant_ing" => $_POST['cant_ing'],
                        "desc_ing" => $_POST['desc_ing'],
                        "id_usr" => $id_usr,
                        "recurrente_ing" => $recurrente,
                        "fecha_ing" => $fecha_rec,
                        "fecha_reg" => $fecha_reg,
                    ]);
                
                    // echo $fecha_rec."<br>";
                }
            
        }
        $respuesta['status'] = 1;

    }elseif ($id_plan == 2 && $poderdeHeeman >= 7) {
        $respuesta["status"] = 2;
    } else {
        $db->insert("ingresos", [
            "nombre_ing" => $_POST['nombre_ing'],
            "cant_ing" => $_POST['cant_ing'],
            "desc_ing" => $_POST['desc_ing'],
            "id_usr" => $id_usr,
            "recurrente_ing" => $recurrente,
            "fecha_ing" => $newDate,
            "fecha_reg" => $fecha_reg,
        ]);
        $respuesta["status"] = 1;
    }
    echo json_encode($respuesta);
}

function getIngreso($id)
{
    global $db;
    $ingreso = $db->get("ingresos", "*", ["id_ing" => $id]);
    $respuesta["nombre_ing"] = $ingreso["nombre_ing"];
    $respuesta["cant_ing"] = $ingreso["cant_ing"];
    $respuesta["desc_ing"] = $ingreso["desc_ing"];
    $respuesta["recurrente_ing"] = $ingreso["recurrente_ing"];
    $respuesta["fecha_ing"] = $ingreso["fecha_ing"];
    $respuesta["fecha_reg"] = $ingreso["fecha_reg"];
    echo json_encode($respuesta);
}

function updateIngreso($id)
{
    global $db, $id_plan, $id_usr, $fecha_baja;
    $respuesta = [];

    $fecha_reg = date("Y-m-d");
    $newDate = date("Y-m-d", strtotime($_POST["fecha_ing"]));
    $mesBj = date("m", strtotime($fecha_baja));
    $anioBJ = date("Y", strtotime($fecha_baja));
    $mes = date("m", strtotime($_POST['fecha_ing']));
    $anio = date("Y", strtotime($_POST['fecha_ing']));

    if ($_POST["recurrente_ing"] == "false" || $_POST["recurrente_ing"] == "") {
        $recurrente = 0;
    } elseif ($_POST["recurrente_ing"] == "true") {
        $recurrente = 1;
    }

    if($id_plan == 2){
        $registros = $db->query("SELECT * FROM ingresos WHERE <id_usr> = $id_usr AND MONTH(<fecha_ing>) = $mes AND YEAR(<fecha_ing>) = $anio")->fetchAll();
        $poderdeHeeman = count($registros);
    }


    if ($_POST["nombre_ing"] == "" || $_POST["cant_ing"] == "" || $_POST["desc_ing"] == "" || $_POST["fecha_ing"] == "") {
        $respuesta["status"] = 0;
    } elseif($anio > $anioBJ){
        //  echo $anio. $anioBJ;
        $respuesta['status'] = 3; 
    }elseif ($id_plan == 2 && $poderdeHeeman >= 7) {
        $respuesta["status"] = 2;
    } else {
        $db->update("ingresos", [
            "nombre_ing" => $_POST['nombre_ing'],
            "cant_ing" => $_POST['cant_ing'],
            "desc_ing" => $_POST['desc_ing'],
            "recurrente_ing" => $recurrente,
            "fecha_ing" => $newDate,
            "fecha_reg" => $fecha_reg
        ], [
            "id_ing" => $id

        ]);
        $respuesta["status"] = 1;
    }
    echo json_encode($respuesta);
}

function deleteIngreso($id)
{
    global $db;
    $db->delete("ingresos", ["id_ing" => $id]);
    $respuesta["status"] = 1;
    echo json_encode($respuesta);
}
