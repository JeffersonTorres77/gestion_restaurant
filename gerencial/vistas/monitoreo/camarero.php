<script>
    const AREA = '<?php echo AREA_GERENCIAL; ?>';
    const MODULO = "monitoreo";
    const ARCHIVO = "camarero";
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

    .hover:hover
    {
        background: rgba(0,0,0,0.05);
    }

    .imagen-pedido
    {
        width: 50px;
        height: 50px;
    }
</style>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header position-relative">
            <h5 class="mb-0">
                Mesas
            </h5>

            <div class="position-absolute p-2" style="top: 0px; right: 0px;">
                <div class="btn btn-sm btn-secondary" id="boton-status">. . .</div>
            </div>
        </div>

        <div class="card-body">
            <div id="contenedor-mesas" class="row">
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">
                    <span id="text-ver-nombreMesa"></span>
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <ul class="list-group list-group-flush" id="lista-pedidos-mesa">
                    <li class="list-group-item">
                        <h5 center class="mb-0">
                            . . .
                        </h5>
                    </li>
                </ul>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
            
        </div>
    </div>
</div>