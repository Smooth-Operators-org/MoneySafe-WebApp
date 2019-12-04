    <!-- MODALS FORMS FOR INFO-PERFIL-USUARIO (POP UP) -->
    <div class="modal" id="modal-info-perfil">
      <div class="modal-content">
        <h5 class="black-text center">Detalles de la Cuenta</h5>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_usr_info" name="nombre_usr_info" class="validate" placeholder="Nombre">
            <label for="nombre_usr_info">Nombre:</label>
          </div>
        </div>
        <div class="row">
          <?php 
          if ($plan_usr == 1) {
            $plan = "Trial";
          }elseif ($plan_usr == 2) {
            $plan = "Basico";
          }elseif ($plan_usr == 3) {
            $plan = "Premium";
          } 
        ?>
          <div class="input-field col s12 l4">
            <input disabled value="<?php echo $plan; ?>" id="plan_actual" type="text" class="validate">
            <label for="plan_actual">Plan contratado:</label>
          </div>
          <div class="input-field col s12 l4">
            <input disabled value="<?php echo $fecha_baja; ?>" id="fecha_venc" type="text" class="validate">
            <label for="fecha_venc">Fecha de vencimiento:</label>
          </div>
          <div class="input-field col s12 l4">
            <input disabled value="<?php echo $days; ?>" id="days" type="text" class="validate">
            <label for="days">Días restantes:</label>
          </div>
        </div>
        <?php 
            if ($plan_usr == 1) {
        ?>
        <div class="row">
          <div class="input-field col s12">
            <p>Plan deseado:</p>
            <select id="id_plan" name="id_plan" class="browser-default">
              <option value="0" selected disabled>Seleccionar:</option>
              <option value="1" selected>Trial</option>
              <option value="2" selected>Basico</option>
              <option value="3" selected>Premium</option>
            </select>
          </div>
        </div>
        <?php
            }else{
        ?>
        <div class="row">
          <div class="input-field col s12">
            <p>Plan deseado:</p>
            <select id="id_plan" name="id_plan" class="browser-default">
              <option value="0" selected disabled>Seleccionar:</option>
              <option value="2" selected>Basico</option>
              <option value="3" selected>Premium</option>
            </select>
          </div>
        </div>
        <?php
            }
        ?>
      </div>
      <div class="modal-footer">
        <button class="modal-close btn red waves-effect waves-light" type="button">Cancelar</button>
        <button class="btn blue-grey darken-2 waves-effect waves-light" type="button"
          id="btn-modal-info">Aceptar</button>
      </div>
    </div>