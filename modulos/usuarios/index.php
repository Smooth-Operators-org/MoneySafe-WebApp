<?php
    require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
    session_start();
    error_reporting(0);
    $id_niv = $_SESSION['nivel'];
    if ($id_niv == 2) {
        header('Location: /index.php');
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
    <title>Usuarios</title>
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
                <h2>Usuarios</h2>
                <a href="#modal-usuarios" class="btn-floating tooltipped pulse modal-trigger right btn-new" data-position="right" data-tooltip="Añadir Usuario"><i class="fas fa-plus"></i></a>
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
                            <th>Email</th>
                            <th>Plan Contratado</th>
                            <th>Status</th>
                            <th>Nivel</th>
                            <th>Fecha de Activación</th>
                            <th>Fecha de Cancelación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once $_SERVER["DOCUMENT_ROOT"].'/includes/_db.php';
                        global $db;
                        $users = $db->select("usuarios", ["id_usr","nombre_usr", "correo_usr", "id_plan", "status_usr", "id_niv", "fecha_alta", "fecha_baja"]);
                        $i = 1;
                        foreach($users as $user){
                    ?>  
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $user["nombre_usr"];?></td>
                            <td><?php echo $user["correo_usr"];?></td>
                            <td>
                                <?php if ($user["id_plan"] == 1) {
                                    echo "Trial";
                                }elseif ($user["id_plan"] == 2) {
                                    echo "Basico";
                                }elseif ($user["id_plan"] == 3) {
                                    echo "Premium";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($user["status_usr"] == 1) {
                                    echo "Activo";
                                }elseif ($user["status_usr"] == 0) {
                                    echo "Inactivo";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($user["id_niv"] == 1) {
                                    echo "Administrador";
                                }elseif ($user["id_niv"] == 2) {
                                    echo "Usuario";
                                }
                                ?>
                            </td>
                            <td><?php echo $user["fecha_alta"];?></td>
                            <td><?php echo $user["fecha_baja"];?></td>
                            <td>
                                <a href="#modal-usuarios" data-modal="<?php echo $user['id_usr']; ?>" class="btn-edit modal-trigger tooltipped" data-position="left" data-tooltip="Editar"><i class="fas fa-edit"></i></a>
                                <a href="#" data-modal="<?php echo $user['id_usr']; ?>" class="btn-delete"><i class="fas fa-trash-alt tooltipped" data-position="right" data-tooltip="Eliminar"></i></a>
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
        <div class="modal" id="modal-usuarios">
            <div class="modal-content">
                <div class="row center-align">
                    <h5 class="black-text" id="modal-title">Nuevo Usuario</h5>
                    <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="nombre_usr" name="nombre_usr" class="validate" placeholder="Nombre">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" id="correo_usr" name="correo_usr" class="validate" placeholder="Email">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" id="password_usr" name="password_usr" class="validate" placeholder="Password">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="id_niv" id="id_niv" class="browser-default">
                            <option value="0" selected disabled>Seleccione un nivel:</option>
                            <?php
                            $niveles = $db->select('niveles', '*');
                                foreach($niveles as $nivel){
                            ?>
                                <option value="<?php echo $nivel['id_niv']; ?>"><?php echo $nivel['nombre_niv']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="id_plan" id="id_plan" class="browser-default">
                            <option value="0">Seleccione un plan:</option>
                            <?php
                            $planes = $db->select('planes', '*');
                                foreach($planes as $plan){
                            ?>
                                <option value="<?php echo $plan['id_plan']; ?>"><?php echo $plan['nombre_plan']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-field col s12 center-align">
                    <span>Status:</span>
                    <div class="switch">
                        <label>
                            Inactivo
                            <input type="checkbox" id="status_usr" name="status_usr">
                            <span class="lever"></span>
                            Activo
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-close btn red waves-effect waves-light" type="button" id="btn-cancel-modal">Cancelar</button>
                <button class="btn green waves-effect waves-light" type="button" id="btn-form-modal">Insertar</button>
            </div>
        </div>
    </div>
    <!-- FONT-AWESOME -->
    <script src="/vendor/fortawesome/font-awesome/js/all.min.js" data-auto-replace-svg="nest"></script>
    <!-- JQUERY -->
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <!-- MATERIALIZE SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- SWEETALERT SCRIPT -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- MAIN SCRIPT -->
    <script src="main.js"></script>
</body>

</html>
<?php
        }else{
            header('Location: /modulos/login/index.php');
        }
    }
?>