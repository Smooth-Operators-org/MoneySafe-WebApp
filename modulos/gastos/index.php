<?php
    require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
    session_start();
    error_reporting(0);
    $id_niv = $_SESSION['nivel'];
    $id_usr = $_SESSION['id'];
    if ($id_niv == 1) {
        header('Location: /modulos/usuarios/index.php');
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
  <link rel="stylesheet" href="/css/estilo.css">
  <!-- MATERIAL-ICONS -->
  <link rel="stylesheet" href="/vendor/mervick/material-design-icons/css/material-icons.css">
  <!-- MATERIALIZE CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <title>Gastos</title>
</head>

<body>

  <!-- SIDENAV -->
  <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/sidenav.php';
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
    <?php if($plan_usr == 2){ ?>
    <!-- MODALS FORMS FOR GASTOS (POP UP) PLAN 2 -->
    <div class="modal" id="modal-gastos">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text" id="modal-title">Nuevo Gasto</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_gst" name="nombre_gst" class="validate" placeholder="Nombre">
          </div>
        </div>
        <!-- SELECT -->
        <div class="row">
          <div class="input-field col s12">
            <select id="id_cat" name="id_cat" class="browser-default">
              
              <?php 
                $categ = $db->select('categorias','*', ['id_usr' => $id_usr]);

                if(!$categ){?>
                  <option value="0" selected disabled>No existen categorias</option>
                  <?php 
                }else{
                  ?>
                  <option value="0" selected disabled>Selecciona una categoria:</option>
                  <?php 
                foreach($categ as $cat){
                  ?>
                  <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['nombre_cat']; ?></option>
                  <?php
                }}
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="number" id="cant_gst" name="cant_gst" min="1" class="validate"
              pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Cantidad">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="desc_gst" name="desc_gst" class="validate" placeholder="Descripción">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="fecha_gst" name="fecha_gst" class="datepicker" placeholder="Fecha del Gasto">
            <input type="hidden" id="varsesion" name="varsesion" class="hidden" value="<?php echo $varsesion?>">
          </div>
        </div>
        <!-- BOTONES MODAL -->
        <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" id="btn-form" type="button">Insertar</button>
        </div>
      </div>
    </div>
              <?php }else{?>
              <!-- MODALS FORMS FOR GASTOS (POP UP) -->
    <div class="modal" id="modal-gastos">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text" id="modal-title">Nuevo Gasto</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_gst" name="nombre_gst" class="validate" placeholder="Nombre">
          </div>
        </div>
        <!-- SELECT -->
        <div class="row">
          <div class="input-field col s12">
            <select id="id_cat" name="id_cat" class="browser-default">
              
              <?php 
                $categ = $db->select('categorias','*', ['id_usr' => $id_usr]);

                if(!$categ){?>
                  <option value="0" selected disabled>No existen categorias</option>
                  <?php 
                }else{
                  ?>
                  <option value="0" selected disabled>Selecciona una categoria:</option>
                  <?php 
                foreach($categ as $cat){
                  ?>
                  <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['nombre_cat']; ?></option>
                  <?php
                }}
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="number" id="cant_gst" name="cant_gst" min="1" class="validate"
              pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Cantidad">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="desc_gst" name="desc_gst" class="validate" placeholder="Descripción">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="fecha_gst" name="fecha_gst" class="datepicker" placeholder="Fecha del Gasto">
            <input type="hidden" id="varsesion" name="varsesion" class="hidden" value="<?php echo $varsesion?>">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 center-align">
            <span>¿Es recurrente?</span>
            <div class="switch">
              <label>
                Off
                <input type="checkbox" id="recurrente_gst" name="recurrente_gst">
                <span class="lever"></span>
                On
              </label>
            </div>
          </div>
        </div>
        <!-- BOTONES MODAL -->
        <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" id="btn-form" type="button">Insertar</button>
        </div>
      </div>
    </div>
              <?php } ?>
    <!-- MODALS FORMS FOR INFO-PERFIL-USUARIO (POP UP) -->
    <div class="modal" id="modal-info-perfil">
      <div class="modal-content">
        <h5 class="black-text center">Detalles de la cuenta</h5>
        <div class="collection">
          <a href="#" class="collection-item no-pointer blue-grey-text"><span class="badge">
            <?php 
              if ($plan_usr == 1) {
                echo "Trial";
              }elseif ($plan_usr == 2) {
                echo "Basico";
              }elseif ($plan_usr == 3) {
                echo "Premium";
              } 
            ?></span>Plan contratado</a>
          <a href="#" class="collection-item no-pointer blue-grey-text"><span class="badge"><?php echo $fecha_baja?></span>Fecha de vencimiento</a>
          <a href="#" class="collection-item no-pointer blue-grey-text"><span class="badge"><?php echo $days?></span>Días restantes</a>
        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-close btn blue-grey darken-2 waves-effect waves-light" type="button">Aceptar</button>
      </div>
    </div>
  </div>
  <!-- FONT-AWESOME -->
  <script src="/vendor/fortawesome/font-awesome/js/all.min.js" data-auto-replace-svg="nest"></script>
  <!-- JQUERY -->
  <script src="/vendor/components/jquery/jquery.min.js"></script>
  <!-- MATERIALIZE SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="/modulos/gastos/main.js"></script>
</body>

</html>
<?php
        }else{
            header('Location: /modulos/login/index.php');
        }
    }
?>