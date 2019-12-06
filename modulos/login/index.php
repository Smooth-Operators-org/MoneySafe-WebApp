<?php 
    require_once '../../includes/_db.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS -->
    <link rel="stylesheet" href="estilo.css">
    <!-- MATERIAL-ICONS -->
    <link rel="stylesheet" href="../../vendor/mervick/material-design-icons/css/material-icons.css">
    <!-- MATERIALIZE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Login</title>
</head>

<body>
    <div class="login-box z-depth-3">
        <div class="row">
            <div class="logo"></div>
        </div>
        <form action="#" id="login-form">
            <div class="row center-align">
                <h5 class="black-text">Iniciar Sesión</h5>
                <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">email</i>
                    <input type="email" id="email" name="email" class="validate" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <input type="password" id="password" name="password" class="validate" placeholder="Password">
                    <p>
                        <label>
                            <input type="checkbox" id="remember" name="remember"/>
                            <span>Recordar Credenciales</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s6" id="mensaje">
                    <a href="#">Registrarse</a>
                </div>
                <div class="col s6 right-align">
                    <button class="btn waves-effect waves-light green accent-4" type="button" id="btn-login">Login</button>
                </div>
            </div>
        </form>
        <form action="#" id="register-form">
            <div class="row center-align">
                <h5 class="black-text">Registrarse</h5>
                <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">face</i>
                    <input type="text" id="nombre_usr" name="nombre_usr" class="validate">
                    <label for="nombre_usr">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">email</i>
                    <input type="email" id="correo_usr" name="correo_usr" class="validate">
                    <label for="correo_usr">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <input type="password" id="password_usr" name="password_usr" class="validate">
                    <label for="password_usr">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <input type="password" id="re_password_usr" name="re_password_usr" class="validate">
                    <label for="re_password_usr">Re-Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="id_plan" id="id_plan">
                        <option value="" disabled selected>Eligé un plan:</option>
                        <?php
                          $planes = $db->select('planes', '*');
                            foreach($planes as $plan){
                        ?>
                              <option value="<?php echo $plan['id_plan']; ?>"><?php echo $plan['nombre_plan']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <label>Plan</label>
                </div>
            </div>
            <div class="row">
                <div class="col s6" id="mensaje">
                    <a href="#">Login</a>
                </div>
                <div class="col s6 right-align">
                    <button class="btn waves-effect waves-light green accent-4" type="button" id="btn-register">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <script src="../../vendor/components/jquery/jquery.min.js"></script>
    <script src="../../vendor/components/jquery-cookie/jquery.cookie.js"></script>
    <script src="../../vendor/fortawesome/font-awesome/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="main.js"></script>
</body>

</html>