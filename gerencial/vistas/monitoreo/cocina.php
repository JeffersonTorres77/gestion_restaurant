<script>
    const AREA = '<?php echo AREA_GERENCIAL; ?>';
    const MODULO = "monitoreo";
    const ARCHIVO = "cocina";
</script>

<style>
    .sombra
    {
        transition-duration: .2s;
    }
    
    .sombra:hover
    {
        box-shadow: 1px 1px 5px #000000;
    }
</style>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header position-relative">
            <h5 class="mb-0">
                Pedidos a preparar
            </h5>

            <div class="position-absolute p-2" style="top: 0px; right: 0px;">
                <div class="btn btn-sm btn-secondary" id="boton-status">. . .</div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="select-area">Area</label>
                        </div>

                        <select class="form-control" id="select-area">
                            <?php
                                $areas = AreasMonitoreoModel::Listado();
                                foreach($areas as $area)
                                {
                                    ?>
                                        <option value="<?php echo $area['idAreaMonitoreo']; ?>">
                                            <?php echo $area['nombre']; ?>
                                        </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div id="contenedor-pedidos" class="row">
                <div class="col-12 p-0 px-3">
                    <div class="card bg-light">
                        <div class="card-body" center>
                            <h5>. . .</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ver">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">Pedido N° <span id="text-ver-idPedido"></span></h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <input type="hidden" id="input-ver-id">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action">
                        <div class="tarjeta-miniatura-pedido">
                            <div class="imagen-pedido">
                                <img src="" alt=". . ." id="img-ver-plato">
                            </div>

                            <div>
                                <div id="input-ver-plato" class="h5 mb-0">
                                    X
                                </div>

                                <div id="input-ver-categoria">
                                    X
                                </div>

                                <div class="badge badge-success" id="tag-combo">En combo</div>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item list-group-item-action">
                        N° de pedido:
                        <span id="input-ver-numero" class="font-weight-bold">X</span>
                    </li>

                    <li class="list-group-item list-group-item-action">
                        Mesa:
                        <span id="input-ver-mesa" class="font-weight-bold">X</span>
                    </li>

                    <li class="list-group-item list-group-item-action">
                        Cantidad:
                        <span id="input-ver-cantidad" class="font-weight-bold">X</span>
                    </li>

                    <li class="list-group-item list-group-item-action">
                        Nota:
                        <span id="input-ver-nota" class="font-weight-bold">X</span>
                    </li>
                </ul>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-primary w-100px" onclick="ConfirmarPedido()">
                    ¡Listo!
                </button>
            </div>
            
        </div>
    </div>
</div>