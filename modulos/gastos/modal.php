<!-- MODALS FORMS FOR GASTOS (POP UP) -->
<div class="modal" id="modal-gastos">
    <div class="modal-content">
        <div class="row center-align">
            <h5 class="black-text" id="modal-title">Nuevo Gasto</h5>
            <h6 class="green-text accent-4"><b>Money-Safe</b></h6>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="nombre_gst" name="nombre_gst" class="validate" placeholder="Nombre">
            </div>
        </div>
        <!-- SELECT -->
        <div class="row">
            <div class="input-field col s12">
                <select id="id_cat" name="id_cat" class="browser-default">

                    <?php 
                $categ = $db->select('categorias','*', ['id_usr' => $id_usr]);

                if(!$categ){?>
                    <option value="0" selected disabled>No existen categorias</option>
                    <?php 
                }else{
                  ?>
                    <option value="0" selected disabled>Selecciona una categoria:</option>
                    <?php 
                foreach($categ as $cat){
                  ?>
                    <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['nombre_cat']; ?></option>
                    <?php
                }}
              ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input type="number" id="cant_gst" name="cant_gst" min="1" class="validate"
                    pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Cantidad">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="desc_gst" name="desc_gst" class="validate" placeholder="Descripción">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="fecha_gst" name="fecha_gst" class="datepicker" placeholder="Fecha del Gasto">
                <input type="hidden" id="varsesion" name="varsesion" class="hidden" value="<?php echo $varsesion?>">
            </div>
        </div>
        <?php 
            if ($plan_usr == 2) {
        ?>
            <!--  -->
        <?php
            }else{
        ?>
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
        <?php
            }
        ?>
        <!-- BOTONES MODAL -->
        <div class="modal-footer">
            <button class="modal-close btn red waves-effect waves-light" id="btn-cancela" type="button">Cancelar</button>
            <button class="btn green waves-effect waves-light" id="btn-form" type="button">Insertar</button>
        </div>
    </div>
</div>