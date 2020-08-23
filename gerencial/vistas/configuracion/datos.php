<div class="m-2 p-2">
    <form class="card" id="form-basico" onsubmit="event.preventDefault()">
        <div class="card-header">
            <h5 class="mb-0">
                Datos basicos

                <a href="#more-info" data-toggle="collapse">
                    <div class="float-right px-2">
                        <i class="fas fa-xs fa-info"></i>
                    </div>
                </a>
            </h5>

            <div class="collapse" id="more-info">
                <div class="mt-2">
                    <b>Documento:</b> <?php echo $objRestaurant->getDocumento(); ?><br>
                </div>

                <div class="text-muted">
                    <b>Registro:</b> <?php echo Formato::Fecha( $objRestaurant->getFechaRegistro() ); ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row justify-content-center">
                <div class="ml-3 mb-3">
                    <input type="file" id="img-logo-restaurant" class="d-none" accept="image/*" name="img">
                    <label class="logo-muestra border-secondary bg-light mb-0" tabindex="0" for="img-logo-restaurant" id="label-logo-restaurant">
                        <img src="<?php echo $objRestaurant->getLogo(); ?>">
                    </label>
                </div>

                <div class="col-12 col-sm">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-documento">Documento</label>
                                <input type="text" id="input-basico-documento" name="documento" class="form-control" value="<?php echo $objRestaurant->getDocumento(); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-nombre">Nombre</label>
                                <input type="text" id="input-basico-nombre" name="nombre" class="form-control" value="<?php echo $objRestaurant->getNombre(); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-telefono">Telefono</label>
                        <input type="tel" id="input-basico-telefono" name="telefono" class="form-control" value="<?php echo $objRestaurant->getTelefono(); ?>">
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-correo">Correo</label>
                        <input type="email" id="input-basico-correo" name="correo" class="form-control" value="<?php echo $objRestaurant->getCorreo(); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-direccion">Dirección</label>
                        <textarea id="input-basico-direccion" name="direccion" class="form-control" cols="30" rows="2"><?php echo $objRestaurant->getDireccion(); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-0">
                        <label class="mb-0" for="input-basico-moneda">Moneda</label>
                        <select name="idMoneda" id="input-basico-moneda" class="form-control">
                            <?php
                                $monedas = MonedasModel::Listado();
                                foreach($monedas as $moneda)
                                {
                                    $id = $moneda['idMoneda'];
                                    $nombre = $moneda['nombre'];
                                    $simbolo = $moneda['simbolo'];
                                    $selected = ($objRestaurant->getIdMoneda() == $id) ? 'selected' : '';

                                    ?>
                                        <option <?php echo $selected; ?> value="<?php echo $id; ?>">
                                            <?php echo "{$nombre} ({$simbolo})"; ?>
                                        </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer" center>
            <button type="reset" class="btn btn-outline-secondary w-100px">Limpiar</button>
            <button type="submit" class="btn btn-primary w-100px">Guardar</button>
        </div>
    </form>
</div>