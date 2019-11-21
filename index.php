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
    <div class="row">
      <div class="col s12 m12 l4">
        <div class="card teal lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-dollar-sign"></i> Ingresos</b></span>
            <p><b>Ingresos registrados: 4</b></p>
            <p><b>Total de ingresos: <i class="fas fa-dollar-sign"></i> 5000</b></p>
          </div>
          <div class="card-action">
            <a href="#modal-ingresos" class="white-text modal-trigger"><b>Añadir nuevo ingreso</b></a>
          </div>
        </div>
      </div>
      <div class="col s12 m12 l4">
        <div class="card blue lighten-1 z-depth-2">
          <div class="card-content white-text">
            <span class="card-title"><b><i class="fas fa-file-invoice-dollar"></i> Gastos</b></span>
            <p><b>Gastos registrados: 4</b></p>
            <p><b>Total de gastos: <i class="fas fa-dollar-sign"></i> 15,000</b></p>
          </div>
          <div class="card-action">
            <a href="#modal-gastos" class="white-text modal-trigger"><b>Añadir nuevo gasto</b></a>
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
            <tr>
              <td>Luz</td>
              <td>Electricidad</td>
              <td>$1,500</td>
            </tr>
          </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text">$1,500</span></b></p>
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
            <tr>
              <td>Sueldo</td>
              <td>$3000</td>
            </tr>
          </tbody>
        </table>
        <div class="collection col s12 m12 l10 offset-l1 blue-grey lighten-1">
          <p class="collection-item blue-grey lighten-1 white-text"><b>Total: <span class="badge white-text">$3,000</b></span></p>
        </div>
      </div>
    </div>
    <!-- TOTAL -->
    <div class="row">
      <div class="col s12 m12 l4 offset-l4">
        <div class="card-panel teal center-align z-depth-2">
          <span class="white-text"><b>Total $1,500</b></span>
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
            <input type="text" id="fecha_ing" name="fecha_ing" class="datepicker container">
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
            <input type="number" id="cant_ing" name="cant_ing" min="1" class="validate" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
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
          <button class="modal-close btn red waves-effect waves-light" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" type="button">Insertar</button>
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
          <button class="modal-close btn red waves-effect waves-light" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" type="button" id="insertCat">Insertar</button>
        </div>
    </div>
  </div>
  <!-- FONT-AWESOME -->
  <script src="/vendor/fortawesome/font-awesome/js/all.min.js" data-auto-replace-svg="nest"></script>
  <!-- JQUERY -->
  <script src="/vendor/components/jquery/jquery.min.js"></script>
  <!-- MATERIALIZE SCRIPT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="/js/main.js"></script>
</body>

</html>