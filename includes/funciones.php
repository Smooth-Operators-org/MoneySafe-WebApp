<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';

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
    global $db;
    $respuesta = [];
    $nombre_cat = $_POST["nombre_cat"];
    $fecha = strftime("%y-%m-%d");
    // if(){}
    $consulta = $db->insert("categorias", ["id_cat"=>"","nombre_cat"=>$nombre_cat, "fecha_reg"=>$fecha]);
    if($consulta){
        $respuesta["status"] = 1;
    } else {
        $respuesta["status"] = 0;
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
    $consulta = $db->update("categorias",["nombre_cat"=>$_POST["nombre_cat"]],["id_cat"=>$id]);
    if($consulta){
        $respuesta["status"] = 1;
    } else {
        $respuesta["status"] = 0;
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