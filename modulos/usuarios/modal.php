        <!-- MODALS FORMS FOR USUARIOS (POP UP) -->
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