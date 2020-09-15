<div class="m-2 p-2">
    <div class="card">
        <div class="card-body p-3">
            <h5 class="mb-0">
                <a href="<?php echo HOST_ADMIN."Usuarios"; ?>">
                    <div class="float-left px-1 mr-2 text-dark">
                        <i class="fas fa-xs fa-arrow-left"></i>
                    </div>
                </a>

                <?php echo $objUsuario->getNombre(); ?>

                <a href="#more-info" data-toggle="collapse">
                    <div class="float-right px-2">
                        <i class="fas fa-xs fa-info"></i>
                    </div>
                </a>
            </h5>

            <div class="collapse" id="more-info">
                <br>

                <div>
                    <b>Usuario:</b> <?php echo $objUsuario->getUsuario(); ?><br>
                    <b>Restaurant:</b> <?php echo $objRestaurant->getNombre(); ?><br>
                    <b>Documento:</b> <?php echo $objRestaurant->getDocumento(); ?><br>
                </div>

                <div class="text-muted">
                    <b>Registro:</b> <?php echo Formato::Fecha( $objUsuario->getFechaRegistro() ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="my-3">
        <nav>
            <div class="nav nav-tabs" id="opciones">
                <a center class="nav-item nav-link active text-truncate w-50" id="opciones-personal" data-toggle="tab" href="#personal">Personal</a>
                <a center class="nav-item nav-link text-truncate w-50" id="opciones-cuenta" data-toggle="tab" href="#cuenta">Cuenta</a>
            </div>
        </nav>

        <div class="tab-content card border-top-0 rounded-0" id="tab-content">

            <!-- PERSONAL -->
            <div class="tab-pane fade show active" id="personal">
                <form id="form-personal" class="card-body" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idUsuario" value="<?php echo $objUsuario->getId(); ?>">

                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label class="mb-0" for="input-personal-documento">Documento</label>
                                <input type="text" id="input-personal-documento" name="documento" class="form-control" value="<?php echo $objUsuario->getDocumento(); ?>">
                            </div>
                        </div>

                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <label class="mb-0" for="input-personal-nombre">Nombre</label>
                                <input type="text" id="input-personal-nombre" name="nombre" class="form-control" value="<?php echo $objUsuario->getNombre(); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-0" for="input-personal-direccion">Dirección</label>
                                <textarea id="input-personal-direccion" name="direccion" class="form-control" cols="30" rows="2"><?php echo $objUsuario->getDireccion(); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label class="mb-0" for="input-personal-telefono">Telefono</label>
                                <input type="tel" id="input-personal-telefono" name="telefono" class="form-control" value="<?php echo $objUsuario->getTelefono(); ?>">
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label class="mb-0" for="input-personal-correo">Correo</label>
                                <input type="email" id="input-personal-correo" name="correo" class="form-control" value="<?php echo $objUsuario->getCorreo(); ?>">
                            </div>
                        </div>
                    </div>
                </form>

                <div center class="card-footer">
                    <button class="btn btn-outline-secondary w-100px" onclick="LimpiarPersonal()">Limpiar</button>
                    <button class="btn btn-success w-100px" onclick="GuardarPersonal()">Guardar</button>
                </div>
            </div>
            <!-- Fin PERSONAL -->





            <!-- CUENTA -->
            <div class="tab-pane fade" id="cuenta">
                <form id="form-cuenta" class="card-body" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idUsuario" value="<?php echo $objUsuario->getId(); ?>">

                    <div class="row justify-content-center">
                        <div class="ml-3 mb-3">
                            <input type="file" id="img-foto-usuario" class="d-none" accept="image/*" name="img">
                            <label class="foto-usuario-muestra border-secondary bg-light mb-0" tabindex="0" for="img-foto-usuario" id="label-foto-usuario">
                                <img src="<?php echo $objUsuario->getFoto(); ?>">
                            </label>
                        </div>

                        <div class="col-12 col-sm">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="input-cuenta-usuario" class="mb-0">Usuario:</label>
                                        <input type="text" class="form-control" id="input-cuenta-usuario" name="usuario" value="<?php echo $objUsuario->getUsuario(); ?>">
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="input-cuenta-clave" class="mb-0">Contraseña:</label>
                                        <input type="password" class="form-control" id="input-cuenta-clave" name="clave" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="input-cuenta-rol" class="mb-0">Rol:</label>
                                        <select class="form-control" id="input-cuenta-rol" name="idRol">
                                            <?php
                                                $roles = RolesModel::ListadoRestaurant($objRestaurant->getId());
                                                foreach($roles as $rol)
                                                {
                                                    $selected = "";
                                                    if($objUsuario->getRol()->getId() == $rol['idRol']) {
                                                        $selected = "selected";
                                                    }

                                                    ?>
                                                        <option <?php echo $selected; ?> value="<?php echo $rol['idRol']; ?>">
                                                            <?php echo $rol['nombre']; ?>
                                                        </option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-switch">
                                <?php
                                    $checked = "";
                                    if($objUsuario->getActivo()) $checked = "checked";
                                    $value = (int) $objUsuario->getActivo();
                                ?>
                                <input type="hidden" name="activo" id="input-cuenta-activo" value="<?php echo $value; ?>">
                                <input type="checkbox" <?php echo $checked ?> id="input-cuenta-activo-aux" class="custom-control-input">
                                <label for="input-cuenta-activo-aux" class="custom-control-label">Activo</label>
                            </div>
                        </div>
                    </div>
                </form>

                <div center class="card-footer">
                    <button class="btn btn-outline-secondary w-100px" onclick="LimpiarCuenta()">Limpiar</button>
                    <button class="btn btn-success w-100px" onclick="GuardarCuenta()">Guardar</button>
                </div>
            </div>
            </div>
            <!-- Fin CUENTA -->

        </div>
    </div>
</div>