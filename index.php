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
    <!-- PHP tarjetas -->
    <?php
      $totalG = $db->sum('gastos','cant_gst', ['id_usr' => $id_usr]);
      $totalI = $db->sum('ingresos','cant_ing', ['id_usr' => $id_usr]);
      $cuentaGastos = $db->count('gastos', '*', ['id_usr' => $id_usr]); 
      $cuentaIngresos = $db->count('ingresos', ['id_usr' => $id_usr]);
      $cuentaCat = $db->count('categorias', ['id_usr' => $id_usr]);
    ?>
    <!-- TARJETAS INFORMATIVAS -->
    <div class="row">
      <!-- TARJETA INGRESOS -->
      <div class="col s12 m12 l4">
        <div class="card teal lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-dollar-sign"></i> Ingresos</b></span>
            <p><b>Ingresos registrados: <?php echo $cuentaIngresos;?></b></p>
            <p><b>Total de ingresos: <i class="fas fa-dollar-sign"></i>
            <?php if($totalI == ""){
                    echo 0;
                  }else{
                    echo $totalI;
            }?>
            </b></p>
          </div>
          <div class="card-action">
            <a href="#modal-ingresos" class="white-text modal-trigger btn-new-ingreso"><b>Añadir nuevo ingreso</b></a>
          </div>
        </div>
      </div>
      <!-- TARJETA GASTOS -->
      <div class="col s12 m12 l4">
        <div class="card blue lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-file-invoice-dollar"></i> Gastos</b></span>
            <p><b>Gastos registrados: <?php echo $cuentaGastos;?></b></p>
            <p><b>Total de gastos: <i class="fas fa-dollar-sign"></i> 
            <?php if($totalG == ""){
                    echo 0;
                  }else{
                    echo $totalG;
            }?>
            </b></p>
          </div>
          <div class="card-action">
            <a href="#modal-gastos" class="white-text modal-trigger btn-new"><b>Añadir nuevo gasto</b></a>
          </div>
        </div>
      </div>
      <!-- TARJETA CATEGORIAS -->
      <div class="col s12 m12 l4">
        <div class="card purple lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-chess-board"></i> Categorías</b></span>
            <p><b>Categorías insertadas: <?php echo $cuentaCat;?></b></p>
            <br>
          </div>
          <div class="card-action">
            <a href="#modal-categorias" class="white-text modal-trigger insert-new__cat"><b>Añadir nueva categoría</b></a>
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
        <h5 id="fecha_nueva"></h5>
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
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1" id="Gastos">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Monto</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text" id="totalGasto"></span></b></p>
        </div>
        <input type="hidden" id="totalG">
      </div>
      <div class="col s12 m12 l6">
        <h4 class="center-align">Ingresos</h4>
        <table class="responsive-table highlight centered grey lighten-2 z-depth-1" id="Ingresos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text" id="totalIngreso"></span></b></p>
        </div>
        <input type="hidden" id="totalI">
      </div>
    </div>
    <!-- TOTAL -->
    <?php 
      $total = $totalI - $totalG;
      if ($total == 0) {
        $color = "grey";
      }else if ($total > 0) {
        $color = "green";
      }else if ($total < 0) {
        $color = "red";
      }
    ?>
    <div class="row">
      <div class="col s12 m12 l4 offset-l4">
        <div class="card-panel center-align z-depth-2 <?php echo $color;?>">
          <b class="white-text">Total: <span class="white-text" id="totalGeneral"><?php echo $total;?> </span></b>
        </div>
      </div>
    </div>
    <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/modal_info.php';
    ?>
    <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/modal_categorias.php';
    ?>
    <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/modal_gastos.php';
    ?>
    <?php 
      Include_once $_SERVER["DOCUMENT_ROOT"].'/shared/modal_ingresos.php';
    ?>
  </div>
  <!-- FONT-AWESOME -->
  <script src="/vendor/fortawesome/font-awesome/js/all.min.js" data-auto-replace-svg="nest"></script>
  <!-- JQUERY -->
  <script src="/vendor/components/jquery/jquery.min.js"></script>
  <!-- MATERIALIZE SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <!-- SWEET ALERT -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- SCRIPT GASTOS -->
  <script src="/modulos/gastos/main.js"></script>
  <!-- SCRIPT INGRESOS -->
  <script src="/modulos/ingresos/main.js"></script>
  <!-- SCRIPT CATEGORIAS -->
  <script src="/modulos/categorias/main.js"></script>
  <script src="/js/main.js"></script>
</body>

</html>
<?php
    }else{
       header('Location: /modulos/login/index.php');
    }              
  }
?>