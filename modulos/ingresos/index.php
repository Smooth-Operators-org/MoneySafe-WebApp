<?php
require_once '../../includes/_db.php';
session_start();
error_reporting(0);
$id_niv = $_SESSION['nivel'];
$id_usr = $_SESSION['id'];
if ($id_niv == 1) {
    header('Location: ../modulos/usuarios/index.php');
} else {
    $varsesion = $_SESSION['email'];
    if (isset($varsesion)) {
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
    <title>Ingresos</title>
</head>

<body>

    <!-- SIDENAV -->
    <?php
        include_once '../../shared/sidenav.php';
    ?>

    <!-- MAIN CONTAINER -->
    <div class="container" id="main-container">
        <div class="row">
            <div class="col s12 24">
                <h2>Ingresos</h2>
                <a href="#modal-ingresos" class="btn-floating tooltipped pulse modal-trigger right btn-new-ingreso"
                    data-position="right" data-tooltip="Añadir ingreso"><i class="fas fa-plus"></i></a>
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
        <!-- TABLA -->
        <div class="row">
            <div class="col s12 m12 24">
                <table class="responsive-table highlight centered grey lighten-2 z-depth-1" id="Ingresos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Monto</th>
                            <th>Descripción</th>
                            <th>Fecha Ingreso</th>
                            <?php if($plan_usr == 1 || $plan_usr == 3){?>
                            <th>Recurrente</th>
                            <?php }?>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="collection col s12 m12 l12  blue-grey lighten-1">
                    <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text" id="totalIngreso"></span></b></p>
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
    } else {
        header('Location: ../modulos/login/index.php');
    }
}
?>