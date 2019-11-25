<?php
require_once $_SERVER["DOCUMENT_ROOT"] . 'includes/_db.php';
session_start();
error_reporting(0);
$id_plan = $_SESSION['plan'];
$id_usr = $_SESSION['id'];
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
    global $db;
    $recurrente = 0;
    if ($_POST["recurrente_ing"] == "true") {
        $recurrente == 1;
    }
    if ($_POST["nombre_ing"] == "" || $_POST["cant_ing"] == "" || $_POST["desc_ing"] == "" || $_POST["fecha_ing"] == "" || $_POST["fecha_reg"] == "") {
        $respuesta["status"] = 0;
    } else {
        $db->insert("ingresos", [
            "nombre_ing" => $_POST['nombre_ing'],
            "cant_ing" => $_POST['cant_ing'],
            "desc_ing" => $_POST['desc_ing'],
            "fecha_ing" => $_POST['fecha_ing'],
            "fecha_reg" => $_POST['fecha_reg'],
            "recurrente_ing" => $recurrente
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
    $respuesta["fecha_ing"] = $ingreso["fecha_ing"];
    $respuesta["fecha_reg"] = $ingreso["fecha_reg"];
    $respuesta["recurrente_ing"] = $ingreso["recurrente_ing"];
    echo json_encode($respuesta);
}

function updateIngreso($id)
{
    global $db;
    $recurrente = 0;
    if ($_POST["nombre_ing"] == "" || $_POST["cant_ing"] == "" || $_POST["desc_ing"] == "" || $_POST["fecha_ing"] == "" || $_POST["fecha_reg"] == "") {
        $respuesta["status"] = 0;
    } else {
        if ($_POST["recurrente_ing"] == "true") {
            $recurrente == 1;
        }
        $db->update("ingresos", [
            "nombre_ing" => $_POST['nombre_ing'],
            "cant_ing" => $_POST['cant_ing'],
            "desc_ing" => $_POST['desc_ing'],
            "fecha_ing" => $_POST['fecha_ing'],
            "fecha_reg" => $_POST['fecha_reg'],
            "recurrente_ing" => $recurrente
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
