<?php 
    $nivel_usr = $_SESSION['nivel'];
    $nombre_usr = $_SESSION['nombre'];
    $correo_usr = $_SESSION['email'];
    $plan_usr = $_SESSION['plan'];
    $fecha_baja = $_SESSION['fecha_baja'];
    $days = $_SESSION['days'];
    $http = "http://";
    $server = $_SERVER['HTTP_HOST'];
    $dir = "/MoneySafe-WebApp";
    $ruta = $http.$server.$dir;
?>
<!-- SIDENAV -->
<aside class="container section">
    <a href="#" class="sidenav-trigger hide-on-large-only" data-target="menu-side">
        <i class="fas fa-bars fa-lg grey-text darken-3"></i>
    </a>

    <ul class="sidenav sidenav-fixed blue-grey darken-2 z-depth-3" id="menu-side">
        <li>
            <div class="user-view">
                <div class="background teal lighten-5"></div>
                <?php 
                if($nivel_usr == 1){
                ?>
                <a href="<?php echo $ruta?>/modulos/usuarios/index.php">
                    <img src="<?php echo $ruta?>/img/MS-Logo.png" alt="" class="circle">
                </a>
                <?php } elseif($nivel_usr == 2){?>
                <a href="<?php echo $ruta?>/index.php">
                <img src="<?php echo $ruta?>/img/MS-Logo.png" alt="" class="circle">
                </a>
                <?php }?>
                <a href="#modal-info-perfil" class="modal-trigger modal-info" data="<?php echo $id_usr ?>">
                    <span class="name black-text"><b><?php echo $nombre_usr?></b></span>
                </a>
                <a href="#" class="no-pointer">
                    <span class="email black-text"><b><?php echo $correo_usr?></b></span>
                </a>
            </div>
        </li>
        <?php
            if ($nivel_usr == 1) {
        ?>
        <li>
            <a href="<?php echo $ruta?>/modulos/usuarios/">
                <i class="fas fa-users fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Usuarios</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $ruta?>/includes/close_session.php">
                <i class="fas fa-sign-out-alt fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Salir</span>
            </a>
        </li>
        <?php
            }elseif ($nivel_usr == 2) {
        ?>
        <li>
            <a href="<?php echo $ruta?>/index.php">
                <i class="fas fa-home fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Home</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $ruta?>/modulos/ingresos/">
                <i class="fas fa-dollar-sign fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Ingresos</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $ruta?>/modulos/gastos/">
                <i class="fas fa-file-invoice-dollar fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Gastos</span>
            </a>
            <a href="<?php echo $ruta?>/modulos/categorias/categorias.php">
                <i class="fas fa-chess-board white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Categorías</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $ruta?>/includes/close_session.php">
                <i class="fas fa-sign-out-alt fa-lg white-text" id="icon_side"></i>
                <span class="white-text" id="span_side">Salir</span>
            </a>
        </li>
        <?php
            }
        ?>
        
    </ul>
</aside>