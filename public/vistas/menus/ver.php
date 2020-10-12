<script>
    const AREA = 'PUBLIC';
    const MODULO = "menus";
    const ARCHIVO = "ver";
    const KEY = '<?php echo Sesion::getKey(); ?>';
</script>

<div class="bg-white p-3 border-bottom">
    <div class="float-left">
        <a href="<?php echo HOST."Menus/"; ?>">
            <div class="pr-2">
                <i class="fas fa-arrow-left"></i>
            </div>
        </a>
    </div>

    <div>
        <label class="text-muted mb-0">Menus</label> /
        <label class="text-muted mb-0">Ver</label> /
        <?php echo $objCombo->getNombre(); ?>
    </div>
</div>

<div class="m-2 p-2">
    <div class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-3">
                <img src="<?php echo $objCombo->getImagen(); ?>" class="card-img rounded-0" alt="Error image" style="height: 162px; object-position: center center; object-fit: cover;">
            </div>
            
            <div class="col-md-9">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><?php echo $objCombo->getNombre(); ?></h5>
                </div>

                <div class="card-body py-2 px-3" style="overflow: auto;">
                    <div style="height: 48px;">
                        <?php echo str_replace("\n", "<br>", $objCombo->getDescripcion()); ?>
                    </div>
                </div>
                
                <div class="card-footer bg-white">
                    <div class="font-weight-bold <?php echo ($objCombo->getDescuento() > 0) ? 'text-success' : 'text-dark' ?>">
                        <?php echo "Descuento: ".Formato::Numero( $objCombo->getDescuento(), 2 )."%"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $descuento = bcdiv( $objCombo->getDescuento() / 100, '1', 2 );
        $arrayPlatos = [];
        $arrayCategorias = [];
        $index = 0;
        $categorias = $objCombo->getCategorias();

        foreach($categorias as $categoria)
        {
            $objCategoria = new CategoriaModel( $categoria['idCategoria'] );
            $idCategoria = $categoria['idCategoria'];
            $cantidadPlatos = $categoria['cantidad'];
            $platos = $objCombo->getPlatos( $objCategoria->getId() );

            array_push($arrayCategorias, [
                "id" => $objCategoria->getId(),
                "nombre" => $objCategoria->getNombre(),
                "descuento" => $objCombo->getDescuento(),
                "limite" => $cantidadPlatos
            ]);

            ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <?php echo "{$objCategoria->getNombre()} (Seleccionadas <b id='label-cantCategoria-{$idCategoria}'>0</b> de {$cantidadPlatos})"; ?>
                        </h5>
                    </div>

                    <div class="card-body">
                        <form class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2" limite="<?php echo $cantidadPlatos; ?>" idCategoria="<?php echo $idCategoria; ?>" id="<?php echo 'form-categoria-'.$idCategoria; ?>" onsubmit="event.preventDefault()">
                            <?php
                                foreach($platos as $plato)
                                {
                                    $objPlato = new PlatoModel( $plato['idPlato'] );
                                    $idPlato = $objPlato->getId();
                                    $precioOriginal = $objPlato->getPrecioVenta();
                                    $precioDescuento = $precioOriginal * (1 - $descuento);

                                    array_push($arrayPlatos, [
                                        "id" => $idPlato,
                                        "nombre" => $objPlato->getNombre(),
                                        "descripcion" => $objPlato->getDescripcion(),
                                        "precio" => $precioOriginal,
                                        "precio_descuento" => $precioDescuento,
                                        "imagen" => $objPlato->getImagen(),
                                        "categoria" => [
                                            "id" => $objCategoria->getId(),
                                            "nombre" => $objCategoria->getNombre()
                                        ],
                                        "cantidad" => 0,
                                        "nota" => ""
                                    ]);

                                    ?>
                                        <div class="mb-3 d-flex justify-content-center px-2" idPlato="<?php echo $idPlato; ?>" idCategoria="<?php echo $idCategoria; ?>" onclick="ModalVer(<?php echo $index; ?>, this)">
                                            <div class="card card-especial-sm" tabindex="0">
                                                <img src="<?php echo $objPlato->getImagen(); ?>" class="card-img-top border-bottom">

                                                <div class="card-body p-3">
                                                    <p class="card-text mb-1">
                                                        <?php echo $objPlato->getNombre(); ?>
                                                    </p>

                                                    <h6 class="card-title mb-0 text-muted" style="text-decoration: line-through;">
                                                        <?php echo Formato::Precio($precioOriginal, $objRestaurant->getMoneda()); ?>
                                                    </h6>

                                                    <h5 class="card-title mb-0 text-success mb-3">
                                                        <?php echo Formato::Precio($precioDescuento, $objRestaurant->getMoneda()); ?>
                                                    </h5>

                                                    <div class="float-right mb-0">
                                                        <input type="text" disabled idPlato="<?php echo $idPlato; ?>" class="form-control bg-white text-center p-1 cantidad" value="0" style="width: 38px; cursor: pointer;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php

                                    $index += 1;
                                }
                            ?>
                        </form>
                    </div>
                </div>
            <?php
        }
    ?>

    <div class="card">
        <div class="card-footer text-center border-0">
            <a href="<?php echo HOST."Menus/"; ?>" class="btn btn-outline-secondary w-100px">
                Cancelar
            </a>

            <button class="btn btn-primary w-100px" onclick="ModalConfirmar()">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
    const ID_COMBO = '<?php echo $objCombo->getId(); ?>';
    const PLATOS = JSON.parse(`<?php echo json_encode($arrayPlatos); ?>`);
    const LIMITES = JSON.parse(`<?php echo json_encode($arrayCategorias); ?>`);
</script>

<div class="modal fade" id="modal-ver">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-img">
                <img src="" id="campo-ver-img" alt=". . .">
            </div>

            <div class="modal-header py-2 px-3 position-relative">
                <div class="mb-0">
                    <div id="campo-ver-nombre" class="h5 mb-0"></div>
                    <div id="campo-ver-categoria" class="text-muted h6 mb-0"></div>

                    <div class="position-absolute p-2" style="top: 0px; right: 0px;">
                        <button class="btn btn-sm btn-danger" id="boton-ver-quitar">
                            <i class="fas fa-times"></i>
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <form id="form-ver" onsubmit="event.preventDefault()">
                        <input type="hidden" name="idPlato" id="campo-ver-id">

                    <div class="mb-3">
                        Descripción:<br>
                        <div id="campo-ver-descripcion" class="p-1"></div>
                    </div>
                    <div id="campo-ver-precio" class="m-0 text-secondary font-weight-bold" style="text-decoration: line-through;"></div>
                    <div id="campo-ver-precioDescuento" class="mb-3 h4 text-success font-weight-bold"></div>

                    <hr>

                    <div class="form-group">
                        <label for="campo-ver-cantidad" class="mb-0">Cantidad:</label>
                        <select required class="form-control" id="campo-ver-cantidad" name="cantidad">
                            <option value="0">Seleccione una cantidad...</option>
                            <?php
                                for($I=1; $I<=10; $I++)
                                {
                                    ?>
                                        <option><?php echo $I; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label for="campo-ver-observaciones" class="mb-0">Nota:</label>
                        <textarea class="form-control" id="campo-ver-observaciones" name="observaciones" placeholder="Nota..." cols="30" rows="3"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" id="boton-confirmar">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmar">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">Confirmar pedido</h5>
            </div>

            <div class="modal-body p-0">
                <div class="h6 border-bottom p-3">
                    Para continuar con el pedido confirme los platillos seleccionados:
                </div>

                <div class="list-group list-group-flush" id="lista-pedidos">
                    <div class="list-group-item" center>
                        <h5 class="mb-0">. . .</h5>
                    </div>
                </div>

                <div class="h5 mb-0 p-3 text-right font-weight-bold">
                    Total: <span class="text-success" id="lista-pedidos-total">. . .</span>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" onclick="ConfirmarPedido()">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>