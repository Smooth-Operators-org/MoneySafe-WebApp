<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';

switch($_POST["accion"]){
    case 'insertarCategoria':
        insertarCategoria();
    break;
}

function insertarCategoria(){
    global $db;
    $respuesta = [];
    $nombre_cat = $_POST["nombre_cat"];
    // if(){}
    $consulta = $db->insert("categorias", ["id_cat"=>"","nombre_cat"=>$nombre_cat]);
    if($consulta){
        $respuesta["status"] = 1;
    } else {
        $respuesta["status"] = 0;
    }
    echo json_encode($respuesta);
}
?>