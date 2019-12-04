    <!-- MODALS FORMS FOR INGRESOS (POP UP) -->
    <div class="modal" id="modal-ingresos">
      <div class="modal-content">
        <div class="row center-align">
          <h5 class="black-text" id="modal-title">Nuevo ingreso</h5>
          <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nombre_ing" name="nombre_ing" class="validate" placeholder="Nombre">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="number" id="cant_ing" name="cant_ing" min="1" class="validate"
              pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Cantidad">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="desc_ing" name="desc_ing" class="validate" placeholder="Descripcion">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="fecha_ing" name="fecha_ing" class="datepicker" placeholder="Fecha ingreso">
            <input type="hidden" id="varsesion" name="varsesion" class="hidden" value="<?php echo $varsesion ?>">
          </div>
        </div>
        <?php if($plan_usr == 2){?>
        <!-- <div class="row">
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
        </div> -->
        <?php }else{ ?>
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
        <?php }?>
        <!-- BOTONES MODAL -->
        <div class="modal-footer">
          <button class="modal-close btn red waves-effect waves-light" id="btn-cancel" type="button">Cancelar</button>
          <button class="btn green waves-effect waves-light" id="btn-form-ingresos" type="button">Insertar</button>
        </div>
      </div>
    </div>