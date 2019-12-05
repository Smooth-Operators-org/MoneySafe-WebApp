<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
 
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
        
        case 'getDataGastos':
            getDataGastos($_POST['id']);
            break;

        case 'getDataIngresos':
            getDataIngresos($_POST['id']);
            break;
        case 'sumarGastos':
            sumarGastos($_POST['id']);
        break;

        case 'sumarIngresos':
            sumarIngresos($_POST['id']);
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

function fixMonth($m){
    if ($m == 0) {
        $m = 01;
    }else if ($m == 1) {
        $m = 02;
    }else if ($m == 2) {
        $m = 03;
    }else if ($m == 3) {
        $m = 04;
    }else if ($m == 4) {
        $m = 05;
    }else if ($m == 5) {
        $m = 06;
    }else if ($m == 6) {
        $m = 07;
    }else if ($m == 7) {
        $m = '08';
    }else if ($m == 8) {
        $m = '09';
    }else if ($m == 9) {
        $m = 10;
    }else if ($m == 10) {
        $m = 11;
    }else if ($m == 11) {
        $m = 12;
    }
    return $m;
}

function getDataGastos($id){
    global $db;
    $month = fixMonth($_POST['month']);
    $year = $_POST['year'];
    $gastos = $db->query("SELECT g.id_usr, g.nombre_gst, g.id_cat, g.cant_gst, g.fecha_gst, c.id_cat, c.nombre_cat  
    FROM gastos as g, categorias as c 
    WHERE <g.id_usr> = $id AND MONTH(<g.fecha_gst>) = $month AND YEAR(<g.fecha_gst>) = $year AND <g.id_cat> = <c.id_cat>")->fetchAll();
    echo json_encode($gastos);
}

function getDataIngresos($id){
    global $db;
    $month = fixMonth($_POST['month']);
    $year = $_POST['year'];
    $ingresos = $db->query("SELECT * FROM ingresos WHERE <id_usr> = $id AND MONTH(<fecha_ing>) = $month AND YEAR(<fecha_ing>) = $year")->fetchAll();
    echo json_encode($ingresos);
}

function sumarGastos($id){
    global $db;
    $month = fixMonth($_POST['month']);
    $year = $_POST['year'];
    $total = $db->query("SELECT SUM(<cant_gst>) as total FROM gastos WHERE <id_usr> = $id AND MONTH(<fecha_gst>) = $month AND YEAR(<fecha_gst>) = $year")->fetchAll();
    echo json_encode($total);
}

function sumarIngresos($id){
    global $db;
    $month = fixMonth($_POST['month']);
    $year = $_POST['year'];
    $total = $db->query("SELECT SUM(<cant_ing>) as total FROM ingresos WHERE <id_usr> = $id AND MONTH(<fecha_ing>) = $month AND YEAR(<fecha_ing>) = $year")->fetchAll();
    echo json_encode($total);
}
?>