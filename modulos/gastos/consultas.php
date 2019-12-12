<?php
 require_once '../../includes/_db.php';
 session_start();
 error_reporting(0);
 $id_plan = $_SESSION['plan'];
 $id_usr = $_SESSION['id'];
 $fecha_baja = $_SESSION['fecha_baja'];

 if ($_POST) {
     switch ($_POST["accion"]) {

        case 'getDataGastos':
            getDataGastos($_POST['id']);
            break;

        case 'sumarGastos':
            sumarGastos($_POST['id']);
            break;
        
        case 'sumarGeneral':
            sumarGeneral($_POST['id']);
            break;

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
        $gastos = $db->query("SELECT g.id_gst, g.id_usr, g.nombre_gst, g.id_cat, g.cant_gst, g.desc_gst, g.recurrente_gst, g.fecha_gst, c.id_cat, c.nombre_cat FROM gastos as g, categorias as c WHERE <g.id_usr> = $id AND MONTH(<g.fecha_gst>) = $month AND YEAR(<g.fecha_gst>) = $year AND <g.id_cat> = <c.id_cat>")->fetchAll();
        echo json_encode($gastos);
    }

    function sumarGastos($id){
        global $db;
        $month = fixMonth($_POST['month']);
        $year = $_POST['year'];
        $total = $db->query("SELECT SUM(<cant_gst>) as total FROM gastos WHERE <id_usr> = $id AND MONTH(<fecha_gst>) = $month AND YEAR(<fecha_gst>) = $year")->fetchAll();
        echo json_encode($total);
    }

    function sumarGeneral($id){
        global $db, $totalG, $totalI;
        $month = fixMonth($_POST['month']);
        $year = $_POST['year'];
        $gastos = $db->query("SELECT SUM(<cant_gst>) as totalG FROM gastos WHERE <id_usr> = $id AND MONTH(<fecha_gst>) = $month AND YEAR(<fecha_gst>) = $year")->fetchAll();
        $ingresos = $db->query("SELECT SUM(<cant_ing>) as totalI FROM ingresos WHERE <id_usr> = $id AND MONTH(<fecha_ing>) = $month AND YEAR(<fecha_ing>) = $year")->fetchAll();
        foreach ($gastos as $g){
            $totalG = $g[0];
        }
        foreach ($ingresos as $i) {
            $totalI = $i[0];
        }
        $respuesta["total"] = $totalI - $totalG;
        echo json_encode($respuesta);
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
        global $db, $id_plan, $id_usr, $fecha_baja;
        $respuesta = [];
        $fecha_reg = date("Y-m-d");
        $idusuario = getIduser();
        $newDate = date("Y-m-d", strtotime($_POST["fecha_gst"]));
        // $mes = fixMonth($_POST['month']);
        // $anio = $_POST['year'];
        $mes = date("m", strtotime($_POST["fecha_gst"]));
        $anio = date("Y", strtotime($_POST["fecha_gst"]));
        $mesBj = date("m", strtotime($fecha_baja));
        $anioBJ = date("Y", strtotime($fecha_baja));
        // CONTEO 7 REGISTROS POR MES PLAN BASICO
        if($id_plan == 2){
            // $registros = $db->count("gastos","*",["id_usr" => $id_usr]); 
            $registros = $db->query("SELECT * FROM gastos WHERE <id_usr> = $id_usr AND MONTH(<fecha_gst>) = $mes AND YEAR(<fecha_gst>) = $anio")->fetchAll();
            $poderdeHeeman = count($registros);
        }
        
        //RECURRENTE
        if($_POST["recurrente_gst"] == "false"){
            $rec = 0;
        }elseif($_POST["recurrente_gst"] == "true"){
            $rec = 1;
        }elseif ($_POST['recurrente_gst'] == "") {
            $rec = 2;
        }
        //VALIDACION INSERTAR  
        if($_POST["nombre_gst"] == "" || $_POST["id_cat"] == "" || $_POST["cant_gst"] == "" ||  $_POST["desc_gst"] == "" || $_POST["fecha_gst"] == ""){
            $respuesta['status'] = 0;
            
        }elseif($anio > $anioBJ){
            // echo $anio. $anioBJ;
            $respuesta['status'] = 3;
        }elseif($rec == 1 ){
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
                            $db->insert("gastos",[
                                "nombre_gst" => $_POST["nombre_gst"],
                                "id_cat" => $_POST["id_cat"],
                                "cant_gst" => $_POST["cant_gst"],
                                "desc_gst" => $_POST["desc_gst"],
                                "id_usr" => $idusuario,
                                "recurrente_gst" => $rec,
                                "fecha_gst" => $fecha_rec,
                                "fecha_reg" => $fecha_reg
                
                            ]);
                        }  
                    }else if($j == 1){
                        for($i = 0; $i <= $mesBj-1; $i++){
                            // echo " anio: ". $anios[$j];  
                            // echo " mes: ". $meses[$i]. "<br>";
                            $fecha_rec = $anios[$j].'-'.$meses[$i].'-'.'02';
                            $db->insert("gastos",[
                                "nombre_gst" => $_POST["nombre_gst"],
                                "id_cat" => $_POST["id_cat"],
                                "cant_gst" => $_POST["cant_gst"],
                                "desc_gst" => $_POST["desc_gst"],
                                "id_usr" => $idusuario,
                                "recurrente_gst" => $rec,
                                "fecha_gst" => $fecha_rec,
                                "fecha_reg" => $fecha_reg
                
                            ]);
                            
                             //echo $fecha_rec."<br>";
                        }
                    }
                }
                
            }else if($anio == $anioBJ){
                $j = 1;
                    for($i = $mes-1; $i <= $mesBj-1; $i++){
                        $fecha_rec = $anios[$j].'-'.$meses[$i].'-'.'02';
                        $db->insert("gastos",[
                            "nombre_gst" => $_POST["nombre_gst"],
                            "id_cat" => $_POST["id_cat"],
                            "cant_gst" => $_POST["cant_gst"],
                            "desc_gst" => $_POST["desc_gst"],
                            "id_usr" => $idusuario,
                            "recurrente_gst" => $rec,
                            "fecha_gst" => $fecha_rec,
                            "fecha_reg" => $fecha_reg
            
                        ]); 
                    
                        // echo $fecha_rec."<br>";
                    }
                
            }
            $respuesta['status'] = 1;
        }elseif($id_plan == 2 && $poderdeHeeman >= 7 ){
           // $respuesta['ola'] = $poderdeHeeman;
            $respuesta['status'] = 2;
        }else{
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
		global $db, $id_plan, $id_usr, $fecha_baja;
        $respuesta = [];
        $fecha_reg = date("Y-m-d");
        $mes = date("m", strtotime($_POST["fecha_gst"]));
        $anio = date("Y", strtotime($_POST["fecha_gst"]));
        $mesBj = date("m", strtotime($fecha_baja));
        $anioBJ = date("Y", strtotime($fecha_baja));
        if($_POST["recurrente_gst"] == "false"){
            $rec = 0;
        }else if($_POST["recurrente_gst"] == "true"){
            $rec = 1;
        }elseif ($_POST['recurrente_gst'] == "") {
            $rec = 2;
        }
        
        if($_POST["nombre_gst"] == "" || $_POST["id_cat"] == "" || $_POST["cant_gst"] == "" ||  $_POST["desc_gst"] == "" || $_POST["fecha_gst"] == ""){
            $respuesta['status'] = 0;
        }elseif($anio > $anioBJ){
            $respuesta['status'] = 3;
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