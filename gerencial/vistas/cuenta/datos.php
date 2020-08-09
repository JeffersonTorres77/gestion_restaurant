<?php
    $objUsuario = Sesion::getUsuario();
?>

<div class="m-2 p-2">
    <div class="card mb-3">
        <div class="card-body p-3">
            <a class="float-left pr-2" href="<?php echo HOST_GERENCIAL; ?>">
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
                        <div class="imagen" center>
                            <img src="<?php echo $objUsuario->getFoto(); ?>" alt="...">
                        </div>

                        <div class="nombre">
                            <?php echo $objUsuario->getNombre(); ?>
                        </div>

                        <div class="acceso">
                            <?php echo $objUsuario->getRol()->getNombre(); ?>
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
                        <input type="text" class="form-control" disabled value="<?php echo $objUsuario->getNombre(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Documento</label>
                        <input type="text" class="form-control" disabled value="<?php echo $objUsuario->getDocumento(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Telefono</label>
                        <input type="text" class="form-control" disabled value="<?php echo $objUsuario->getTelefono(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Correo</label>
                        <div class="input-group">
                            <input type="email" class="form-control" value="<?php echo $objUsuario->getCorreo(); ?>" id="datos-correo">
                            <div class="input-group-append">
                                <button class="btn btn-success" disabled id="boton-correo">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Dirección</label>
                        <textarea class="form-control" disabled cols="30" rows="3"><?php echo $objUsuario->getDireccion(); ?></textarea>
                    </div>
                </div>

                <div class="card-header border-top">
                    <h5 class="mb-0">Datos de la cuenta</h5>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="mb-0">Usuario</label>
                        <input type="text" class="form-control" disabled value="<?php echo $objUsuario->getUsuario(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Acceso</label>
                        <input type="text" class="form-control" disabled value="<?php echo $objUsuario->getRol()->getNombre(); ?>">
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="datos-clave">
                            <div class="input-group-append">
                                <button class="btn btn-success" disabled id="boton-clave">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>