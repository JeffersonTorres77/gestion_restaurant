<div class="p-2 m-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Administración</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-4">
                        <label class="mb-0" for="input-idMoneda">Moneda</label>
                        <select name="idMoneda" id="input-idMoneda" class="form-control">
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

                <div class="col-12 col-md-6">
                    <div class="form-group mb-4">
                        <label for="input-iva" class="mb-0">Impuestos</label>
                        <input type="number" class="form-control" id="input-iva" value="<?php echo $objRestaurant->getIva(); ?>">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group m-0">
                        <label class="mb-1">Imprimir despues de:</label>

                        <?php
                            $checked_1 = ($objRestaurant->getImprimirFactura()) ? 'checked' : '';
                        ?>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="input-facturar" <?php echo $checked_1; ?>>
                            <label class="custom-control-label" for="input-facturar">Facturar</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer" center>
            <button class="btn btn-primary" id="boton-guardar">
                Guardar
            </button>
        </div>
    </div>
</div>