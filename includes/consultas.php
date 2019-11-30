<?php
 require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
 
 session_start();
 error_reporting(0);
//  $id_plan = $_SESSION['plan'];
//  $id_usr = $_SESSION['id'];

 if ($_POST) {
     switch ($_POST["accion"]) {
        case 'atras':
            atras($_POST['fecha_actual']);
            break;

        case 'adelante':
            adelante($_POST['fecha_actual']);
            break;

        default:
            # code...
            break;
     }
 }

function atras($fecha_actual){
    $d=strtotime("-1 Months");
    $nueva_fecha = date("F Y" , $d);
    echo json_encode($nueva_fecha);
}

function adelante($fecha_actual){
    $d = strtotime("+1 Months");
    $nueva_fecha = date("F Y", $d);
    echo json_encode($nueva_fecha);
}
?>