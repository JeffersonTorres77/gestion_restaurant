<form class="m-2 p-2" onsubmit="event.preventDefault()" id="form-datos">
    <input type="hidden" name="idUsuario" value="<?php echo $objUsuario->getId(); ?>">

    <div class="card mb-3">
        <div class="card-body p-3">
            <a class="float-left pr-2" href="<?php echo HOST_GERENCIAL."Usuarios/"; ?>">
                <i class="fas fa-sm fa-arrow-left"></i>
            </a>

            <h5 class="mb-0">
                Datos de la cuenta

                <a href="#more-info" data-toggle="collapse">
                    <div class="float-right px-2">
                        <i class="fas fa-xs fa-info"></i>
                    </div>
                </a>
            </h5>
            
            <div class="collapse" id="more-info">
                <div class="text-muted">
                    <div class="mt-2">
                        <b>Registro:</b> <?php echo Formato::Fecha( $objUsuario->getFechaRegistro() ); ?>
                    </div>

                    <div>
                        <b>Ult. Modif.:</b> <?php echo Formato::Fecha( $objUsuario->getFechaModificacion() ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-3">
                <div class="card-body" center>
                    <div class="datos-perfil">
                        <input type="file" id="img-foto-usuario" class="d-none" accept="image/*" name="img">
                        <label input class="imagen border-secondary mb-0" tabindex="0" for="img-foto-usuario" id="label-foto-usuario">
                            <img src="<?php echo $objUsuario->getFoto(); ?>" alt="...">
                        </label>

                        <div class="nombre mt-2">
                            <?php echo $objUsuario->getNombre(); ?>
                        </div>

                        <div class="row justify-content-center">
                            <div class="acceso col-10">
                                <select class="form-control" name="idRol" id="">
                                    <?php
                                        $idRolActual = $objUsuario->getRol()->getId();
                                        $objRestaurant = Sesion::getRestaurant();
                                        $roles = RolesModel::ListadoRestaurant($objRestaurant->getId());
                                        foreach($roles as $rol)
                                        {
                                            $selected = ($rol['idRol'] == $idRolActual) ? 'selected' : '';

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

                        <div class="custom-control custom-switch mt-2">
                            <?php
                                $checked = ($objUsuario->getActivo()) ? 'checked' : '';
                                $value = (int) $objUsuario->getActivo();
                            ?>
                            <input type="hidden" name="activo" id="input-activo" value="<?php echo $value; ?>">
                            <input type="checkbox" <?php echo $checked ?> id="input-activo-aux" class="custom-control-input">
                            <label for="input-activo-aux" class="custom-control-label">Activo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Datos</h5>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="mb-0">Nombre</label>
                        <input type="text" required name="nombre" class="form-control" value="<?php echo $objUsuario->getNombre(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Documento</label>
                        <input type="text" required name="documento" class="form-control" value="<?php echo $objUsuario->getDocumento(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Telefono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $objUsuario->getTelefono(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Correo</label>
                        <input type="email" required name="correo" class="form-control" value="<?php echo $objUsuario->getCorreo(); ?>" id="datos-correo">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Dirección</label>
                        <textarea class="form-control" name="direccion" cols="30" rows="3"><?php echo $objUsuario->getDireccion(); ?></textarea>
                    </div>
                </div>

                <div class="card-header border-top">
                    <h5 class="mb-0">Datos de la cuenta</h5>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="mb-0">Usuario</label>
                        <input type="text" required name="usuario" class="form-control" value="<?php echo $objUsuario->getUsuario(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Acceso</label>
                        <select required name="acceso" class="form-control">
                            <?php
                                $roles = RolesModel::Listado(Sesion::getRestaurant()->getId());
                                $idRolUsuario = $objUsuario->getRol()->getId();
                                foreach($roles as $rol)
                                {
                                    $idRol = $rol['idRol'];
                                    $nombre = $rol['nombre'];

                                    $selected = ($idRolUsuario == $idRol) ? 'selected' : '';

                                    ?>
                                        <option <?php echo $selected; ?> value="<?php echo $idRol; ?>">
                                            <?php echo $nombre; ?>
                                        </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="card-footer" center>
                    <button class="btn btn-success w-200px" onclick="GuardarDatos()">
                        <i class="fas fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>