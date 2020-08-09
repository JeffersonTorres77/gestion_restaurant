<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"> Nuevo Usuario </h5>
        </div>

        <div class="card-body">

            <form id="form-nuevo" onsubmit="event.preventDefault()">                
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="input-nuevo-documento">Documento:</label>
                            <input type="text" class="form-control" id="input-nuevo-documento" name="documento" required>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-9">
                        <div class="form-group">
                            <label for="input-nuevo-nombre">Nombre:</label>
                            <input type="text" class="form-control" id="input-nuevo-nombre" name="nombre" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="input-nuevo-direccion">Dirección:</label>
                            <textarea class="form-control" id="input-nuevo-direccion" name="direccion" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="input-nuevo-telefono">N° de Telefono:</label>
                            <input type="tel" class="form-control" id="input-nuevo-telefono" name="telefono">
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-9">
                        <div class="form-group">
                            <label for="input-nuevo-correo">Correo electronico:</label>
                            <input type="email" required class="form-control" id="input-nuevo-correo" name="correo">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="input-nuevo-usuario">Usuario:</label>
                            <input type="text" class="form-control" id="input-nuevo-usuario" name="usuario" required>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="input-nuevo-rol">Rol:</label>
                            <select class="form-control" id="input-nuevo-rol" name="rol" required>
                                <?php
                                    $roles = RolesModel::Listado($objRestaurant->getId());
                                    foreach($roles as $rol)
                                    {
                                        ?>
                                            <option value="<?php echo $rol['idRol']; ?>">
                                                <?php echo $rol['nombre']; ?>
                                            </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="input-nuevo-clave">Contraseña:</label>
                            <input type="password" class="form-control" id="input-nuevo-clave" name="clave" required>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="input-nuevo-clave2">Verifique contraseña:</label>
                            <input type="password" class="form-control" id="input-nuevo-clave2" name="clave2" required>
                        </div>
                    </div>
                </div>
            </form>
        
        </div>
        
        <div center class="card-footer">
            <button class="btn btn-outline-secondary w-100px" onclick="history.go(-1)">
                Atras
            </button>

            <button class="btn btn-primary w-100px" onclick="ClickBoton()">
                Registrar
            </button>
        </div>
    </div>
</div>