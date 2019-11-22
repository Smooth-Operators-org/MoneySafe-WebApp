<?php 
  require_once $_SERVER["DOCUMENT_ROOT"].'includes/_db.php';
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
        <a href="#modal-gastos" class="btn-floating tooltipped pulse modal-trigger right" data-position="right" data-tooltip="Añadir gasto"><i class="fas fa-plus"></i></a>
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
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $gastos = $db->select('gastos','*');
            $total = 0;
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
                    echo $categoria; }?>
              </td>
              <td><?php echo $gasto['cant_gst'];?></td>
              <td><?php echo $gasto['desc_gst'];?></td>
              <td><?php echo $gasto['fecha_gst'];?></td>
              <td>
                <a href="#modal-gastos" data="<?php echo $gasto['id_gst']?>" class="btn-edit modal-trigger"><i class="fas fa-edit"
                    title="Editar"></i></a>
                <a href="#" data="<?php echo $gasto['id_gst']?>" class="btn-delete"><i class="fas fa-trash-alt"
                    title="Eliminar"></i></a>
              </td>
              <?php
                $num = $num + 1;
                $total = $total + $gasto['cant_gst'];
                }
              }else{
                 echo "<script>errorAlert()</script>";
                }
              ?>
            </tr>
          </tbody>
        </table>
        <div class="collection col s8 m8 l4  blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span
                class="badge white-text">$<?php echo $total;?></span></b></p>
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
            <input type="text" id="nombre_gst" name="nombre_gst" class="validate">
            <label for="nombre_gst">Nombre</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <select id="fecha_gst" name="fecha_gst">
              <option value="" disabled selected>Selecciona una opción:</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
            <label>Categoría</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="number" id="cant_ing" name="cant_ing" min="1" class="validate"
              pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
            <label for="cant_ing">Cantidad</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="desc_gst" name="desc_gst" class="validate">
            <label for="desc_gst">Descripción</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="fecha_gst" name="fecha_gst" class="datepicker">
            <label for="fecha_gst">Fecha del Gasto</label>
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
        <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" id="btn-form" type="button">Insertar</button>
        </div>
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