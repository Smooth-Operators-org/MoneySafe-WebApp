<?php
require_once '../../includes/_db.php';
session_start();
error_reporting(0);
$id_usr = $_SESSION['id'];
$nivel = $_SESSION['plan'];

switch($_POST["accion"]){
    case 'insertarCategoria':
        insertarCategoria();
    break;
    case 'verCategorias':
        verCategorias();
    break;
    case 'uniCat':
        uniCat($_POST["id"]);
    break;
    case 'editCat':
        editCat($_POST["id_cat"]);
    break;

    case 'deleteCat':
        deleteCat($_POST["categoria"]);
        break;
}

function insertarCategoria(){
    global $db, $id_usr, $nivel;
    $respuesta = [];
    $nombre_cat = $_POST["nombre_cat"];
    $fecha = strftime("%y-%m-%d");
    if($nivel == 2){
        $cuenta = $db->count('categorias','*', ['id_usr' => $id_usr]);
    }

    if ($nombre_cat == "") {
        $respuesta["status"] = 0;
    }elseif($nivel == 2 && $cuenta >=5){
        $respuesta["status"] = 2;
    }else{
        $consulta = $db->insert("categorias", ["id_cat"=>"","nombre_cat"=>$nombre_cat, "id_usr"=>$id_usr, "fecha_reg"=>$fecha]);
        $respuesta["status"] = 1;
    }
    echo json_encode($respuesta);
}

function verCategorias(){
    global $db;
    $respuesta = [];
    $consulta = $db->select("categorias", ["nombre_cat", "fecha_reg"]);
    if($consulta){
        $respuesta["status"] = 1;
    } else {
        $respuesta["status"]= 0;
    }
    echo json_encode($respuesta);
}

function uniCat($idc){
    global $db;
    // $respuesta = [];
    $consulta = $db->get("categorias", "*",["id_cat"=>$idc]);
    // if($consulta){
    //     $respuesta = $consulta;
    // }
    echo json_encode($consulta);
}

function editCat($id){
    global $db;
    $respuesta = [];
    if ($_POST["nombre_cat"] == "") {
        $respuesta["status"] = 0;
    }else{
        $consulta = $db->update("categorias",["nombre_cat"=>$_POST["nombre_cat"]],["id_cat"=>$id]);
        $respuesta["status"] = 1;
    }
    echo json_encode($respuesta);
}


function deleteCat($id){
    global $db;
    $db->delete("categorias", ["id_cat" => $id]);
    $respuesta["status"] = 1;
    echo json_encode($respuesta);
}

?>