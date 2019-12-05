<?php
    require_once '../../includes/_db.php';
    session_start();
    error_reporting(0);
    $id_niv = $_SESSION['nivel'];
    $id_usr = $_SESSION['id'];
    if ($id_niv == 1) {
        header('Location: ../modulos/usuarios/index.php');
    }else{
        $varsesion = $_SESSION['email'];
        if (isset($varsesion)){   
          
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSS -->
  <link rel="stylesheet" href="../../css/estilo.css">
  <!-- MATERIAL-ICONS -->
  <link rel="stylesheet" href="../../vendor/mervick/material-design-icons/css/material-icons.css">
  <!-- MATERIALIZE CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <title>Gastos</title>
</head>

<body>

  <!-- SIDENAV -->
  <?php 
      Include_once '../../shared/sidenav.php';
  ?>

  <!-- MAIN CONTAINER -->
  <div class="container" id="main-container">
    <div class="row">
      <div class="col s12 24">
        <h2>Gastos</h2>
        <a href="#modal-gastos" class="btn-floating tooltipped pulse modal-trigger right btn-new" data-position="right" data-tooltip="Añadir gasto"><i class="fas fa-plus"></i></a>
      </div>
    </div>

    <!-- TABLA -->
    <div class="row">
      <div class="col s12 m12 24">
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Monto</th>
              <th>Descripción</th>
              <th>Fecha del Gasto</th>
              <?php if($plan_usr == 1 || $plan_usr == 3){?>
              <th>Recurrente</th>
              <?php }?>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $gastos = $db->select('gastos','*', ['id_usr' => $id_usr]);
            $total = $db->sum('gastos','cant_gst', ['id_usr' => $id_usr]);
            if($gastos){
              $num = 1;
              foreach($gastos as $gasto){
          ?>
            <tr>
              <td><?php echo $num?></td>
              <td><?php echo utf8_encode($gasto['nombre_gst']);?></td>
              <td><?php 
              $categoria = $db->get('categorias','nombre_cat',['id_cat'=>$gasto['id_cat']]);
                  if($categoria){
                    echo utf8_encode($categoria); }?>
              </td>
              <td><?php echo $gasto['cant_gst'];?></td>
              <td><?php echo $gasto['desc_gst'];?></td>
              <td><?php echo $gasto['fecha_gst'];?></td>
                    <?php if($plan_usr == 1 || $plan_usr == 3 ){?>
              <td><?php 
              if( $gasto['recurrente_gst'] == 1){
                echo "Si";
              } elseif($gasto['recurrente_gst'] == 0){
                echo "No";
              }
              ?></td>
              <?php } ?>
              <td>
                <a href="#modal-gastos" data="<?php echo $gasto['id_gst']?>" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                <a href="#" data="<?php echo $gasto['id_gst']?>" class="btn-delete tooltipped" data-position="right" data-tooltip="Eliminar"><i class="fas fa-trash-alt"></i></a>
              </td>
              <?php
                $num = $num + 1;
                }
              }
              ?>
            </tr>
          </tbody>
        </table>
        <div class="collection col s8 m8 l4  blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span
                class="badge white-text">$<?php 
                if($total == ""){
                  echo 0;
                }else{
                echo $total;
              }
                ?></span></b></p>
        </div>
      </div>
    </div>
    <?php 
      Include_once '../../shared/modal_info.php';
    ?>
    <?php 
      Include_once 'modal.php';
    ?>
  </div>
  <!-- FONT-AWESOME -->
  <script src="../../vendor/fortawesome/font-awesome/js/all.min.js" data-auto-replace-svg="nest"></script>
  <!-- JQUERY -->
  <script src="../../vendor/components/jquery/jquery.min.js"></script>
  <!-- MATERIALIZE SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="main.js"></script>
</body>

</html>
<?php
        }else{
            header('Location: ../modulos/login/index.php');
        }
    }
?>