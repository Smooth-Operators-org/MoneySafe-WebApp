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
  <title>Categorías</title>
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
        <h2>Categorías</h2>
        <a href="#modal-categorias" class="btn-floating tooltipped pulse modal-trigger right insert-new__cat" data-position="right" data-tooltip="Añadir gasto"><i class="fas fa-plus"></i></a>
      </div>
    </div>

    <!-- TABLA -->
    <div class="row">
      <div class="col s12 m12 24">
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1">
          <thead>
            <tr>
              <th>#</th>
              <th>Categoría</th>
              <th>Fecha del Registro</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
            global $db;
            $i = 1;
            $consulta = $db->select('categorias', '*', ['id_usr' => $id_usr]);
            foreach($consulta as $c){
            ?>
            <tr>
              <td><?php echo $i?></td>
              <td><?php echo $c["nombre_cat"]; ?></td>
              <td><?php echo $c["fecha_reg"]; ?></td>
              <td>
                <a href="#modal-categorias" data-modalxd="<?php echo $c['id_cat']; ?>" class="btn-edit modal-trigger editedit"><i class="fas fa-edit"
                    title="Editar"></i></a>
                <a href="#" data-modalxd="<?php echo $c['id_cat']; ?>" class="btn-delete"><i class="fas fa-trash-alt"
                    title="Eliminar"></i></a>
              </td>
            </tr>
            <?php
            $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MODALS FORMS FOR CATEGORIAS (POP UP) -->
    <div class="modal" id="modal-categorias">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text" id="modal-title">Nuevo Categoría</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_cat" name="nombre_cat" class="validate" placeholder="Nombre">
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light insertCat" type="button">Insertar</button>
          <button class="btn green waves-effect waves-light editCat" type="button">Editar</button>
        </div>
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
            header('Location: /modulos/login/index.php');
        }
    }
?>
