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
  <title>Home</title>
</head>

<body>
  <!-- SIDENAV -->
  <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/sidenav.php';
  ?>
  <!-- MAIN CONTAINER -->
  <div class="container" id="main-container">
    <div class="row">
      <div class="col s12 l4">
        <h2>Dashboard</h2>
      </div>
    </div>
    <!-- TARJETAS INFORMATIVAS -->
    <!-- PHP tarjetas -->
    <?php 
      $cuentaGastos = $db->count('gastos', ['id_usr' => $id_usr]);
      $totalG = $db->sum('gastos','cant_gst', ['id_usr' => $id_usr]);

      $cuentaIngresos = $db->count('ingresos', ['id_usr' => $id_usr]);
      $totalI = $db->sum('ingresos','cant_ing', ['id_usr' => $id_usr]);
    ?>
    <div class="row">
      <div class="col s12 m12 l4">
        <div class="card teal lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-dollar-sign"></i> Ingresos</b></span>
            <p><b>Ingresos registrados: <?php echo $cuentaIngresos  ;?></b></p>
            <p><b>Total de ingresos: <i class="fas fa-dollar-sign"></i><?php if($totalI == ""){
                  echo 0;
                }else{
                echo $totalI;
              }?></b></p>
          </div>
          <div class="card-action">
            <a href="#modal-ingresos" class="white-text modal-trigger"><b>Añadir nuevo ingreso</b></a>
          </div>
        </div>
      </div>
      <!-- TARJETA GASTOS -->
      <div class="col s12 m12 l4">
        <div class="card blue lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-file-invoice-dollar"></i> Gastos</b></span>
            <p><b>Gastos registrados: <?php echo $cuentaGastos;?></b></p>
            <p><b>Total de gastos: <i class="fas fa-dollar-sign"></i> <?php if($totalG == ""){
                  echo 0;
                }else{
                echo $totalG;
              }?></b></p>
          </div>
          <div class="card-action">
            <a href="#modal-gastos" class="white-text modal-trigger btn-new"><b>Añadir nuevo gasto</b></a>
          </div>
        </div>
      </div>
      <div class="col s12 m12 l4">
        <div class="card purple lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-chess-board"></i> Categorías</b></span>
            <p><b>Categorías insertadas: 4</b></p>
            <br>
          </div>
          <div class="card-action">
            <a href="#modal-categorias" class="white-text modal-trigger"><b>Añadir nueva categoría</b></a>
          </div>
        </div>
      </div>
    </div>
    <!-- BOTONES Y FECHA -->
    <div class="row section">
      <div class="col s4 m4 l2 left-align">
        <button type="button" id="left" class="btn-floating btn-large waves-effect waves-light blue-grey lighten-1 z-depth-2">
          <i class="fas fa-chevron-left center-align"></i>
        </button>
      </div>
      <div class="col s4 m4 l8 center-align">
        <h5>Fecha Actual</h5>
      </div>
      <div class="col s4 m4 l2 right-align">
        <button type="button" id="right" class="btn-floating btn-large waves-effect waves-light blue-grey lighten-1 z-depth-2">
          <i class="fas fa-chevron-right center-align"></i>
        </button>
      </div>
    </div>
    <!-- TABLAS -->
    <div class="row">
      <div class="col s12 m12 l6">
        <h4 class="center-align">Gastos</h4>
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Monto</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $gastos = $db->select('gastos','*',['id_usr' => $id_usr]);
            if($gastos){
              $num = 1;
              foreach($gastos as $gasto){
          ?>
            <tr>
              <td><?php echo utf8_encode($gasto['nombre_gst']);?></td>
              <td><?php 
              $categoria = $db->get('categorias','nombre_cat',['id_cat'=>$gasto['id_cat']]);
                  if($categoria){
                    echo utf8_encode($categoria); }?>
              </td>
              <td><?php echo $gasto['cant_gst'];?></td>
              <?php
                $num = $num + 1;
                }
              }
              ?>
            </tr>
          </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text"> $<?php if($totalG == ""){
                  echo 0;
                }else{
                echo $totalG;
              }?></span></b></p>
        </div>
      </div>
      <div class="col s12 m12 l6">
        <h4 class="center-align">Ingresos</h4>
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Monto</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $ingresos = $db->select('ingresos','*',['id_usr' => $id_usr]);
            if($ingresos){
              $num = 1;
              foreach($ingresos as $ingreso){
          ?>
            <tr>
              <td><?php echo utf8_encode($ingreso['nombre_ing']);?></td>
              <td><?php echo $ingreso['cant_ing'];?></td>
              <?php
                $num = $num + 1;
                }
              }
              ?>
            </tr>
          </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text">$<?php if($totalI == ""){
                  echo 0;
                }else{
                echo $totalI;
              }?></span></b></p>
        </div>
      </div>
    </div>
    <!-- TOTAL -->
    <div class="row">
      <div class="col s12 m12 l4 offset-l4">
        <div class="card-panel teal center-align z-depth-2">
          <span class="white-text"><b>Total $
          <?php 
        $total = $totalI - $totalG;
           if($total == ""){
             echo 0;
           }else{
           echo $total;
         }
           ?>
          </b></span>
        </div>
      </div>
    </div>
    <!-- MODALS FORMS FOR INGRESOS (POP UP) -->
    <div class="modal" id="modal-ingresos">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text">Nuevo Ingreso</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_ing" name="nombre_ing" class="validate">
            <label for="nombre_ing">Nombre</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="number" id="cant_ing" name="cant_ing" min="1" class="validate" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
            <label for="cant_ing">Cantidad</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="desc_ing" name="desc_ing" class="validate">
            <label for="desc_ing">Descripción</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="fecha_ing" name="fecha_ing" class="datepicker">
            <input type="hidden" id="varsesion" name="varsesion" class="hidden" value="<?php echo $varsesion?>">
            <label for="fecha_ing">Fecha de Ingreso</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 center-align">
          <span>¿Es recurrente?</span>
            <div class="switch">
              <label>
                  Off
                <input type="checkbox" id="recurrente_ing" name="recurrente_ing">
                <span class="lever"></span>
                  On
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" type="button">Insertar</button>
        </div>
      </div>
    </div>
    <!-- MODALS FORMS FOR GASTOS (POP UP) -->
    <div class="modal" id="modal-gastos">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text">Nuevo Gasto</h5>
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
            <select id="id_cat" name="id_cat">
              <option value="" disabled selected>Selecciona una categoria:</option>
              <?php 
                $categ = $db->select('categorias','*');
                foreach($categ as $cat){
                  ?>
                  <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['nombre_cat']; ?></option>
                  <?php
                }
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
  </div>
    <!-- MODALS FORMS FOR CATEGORIAS (POP UP) -->
    <div class="modal" id="modal-categorias">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text">Nuevo Categoría</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_cat" name="nombre_cat" class="validate">
            <label for="nombre_cat">Nombre</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" type="button">Insertar</button>
      </div>
    </div>
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
  <script src="/js/main.js"></script>
  <!-- SWEET ALERT -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- SCRIPT GASTOS -->
  <script src="/modulos/gastos/main.js"></script>
</body>

</html>
<?php
    }else{
       header('Location: /modulos/login/index.php');
    }              
  }
?>