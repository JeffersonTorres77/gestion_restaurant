<script>
    const AREA = '<?php echo AREA_GERENCIAL; ?>';
    const MODULO = "monitoreo";
    const ARCHIVO = "caja";
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

    #div-absoluto
    {
        position: fixed;
        overflow: auto;
        transition-property: left;
        transition-duration: .2s;
        top: 0px;
        left: 100%;
    }

    #div-absoluto[show]
    {
        left: 0px;
    }

    #monitoreo
    {
        transition-duration: .2s;
        opacity: 1;
    }
    
    #monitoreo[hide]
    {
        opacity: 0;
    }
</style>

<!--
    *
-->
<div class="m-2 p-2 position-relative" id="monitoreo">
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

<!--
    *
-->
<div class="modal fade" id="modal-ver">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modal-ver-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white border-bottom-0" id="modal-ver-header">
                <h5 class="mb-0" id="modal-ver-title"></h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <form class="list-group list-group-flush" id="lista-pedidos-mesa" onsubmit="event.preventDefault()">
                    <div id="modal-ver-alarma"></div>
                    <table class="table table-hover table-striped table-bordered mb-0">
                        <thead class="table-sm">
                            <tr>
                                <th style="min-width: 200px;" class="w-auto">Item</th>
                                <th class="w-100px">Status</th>
                                <th class="w-150px">Precio</th>
                                <th class="w-50px">Cantidad</th>
                                <th class="w-150px">Total</th>
                            </tr>
                        </thead>

                        <tbody id="modal-ver-tbody">
                            <tr>
                                <td colspan="100">
                                    <h5 class="mb-0 py-2" center>. . .</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="modal-footer bg-light border-top-0">
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-success w-100px" id="boton-facturar">
                    Continuar
                </button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="modal-datos-factura">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    Datos de la factura
                    <button class="close" data-dismiss="modal">&times;</button>
                </h5>
            </div>

            <div class="card-body">
                <form onsubmit="event.preventDefault()" id="form-datos-factura">
                    <div class="form-group mb-0">
                        <label class="mb-0">Numero de factura:</label>
                        <input type="number" id="numero_factura" class="form-control" required placeholder="Numero de factura...">
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light" center>
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cancelar
                </button>
                
                <button class="btn btn-primary w-100px" id="boton-facturar-final">
                    Facturar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-eliminar-pedido">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    Eliminar pedido
                    <button class="close" data-dismiss="modal">&times;</button>
                </h5>
            </div>

            <div class="card-body">
                <form onsubmit="event.preventDefault()" id="form-eliminar-pedido">
                    <div class="form-group mb-0">
                        <label class="mb-0">Motivo:</label>
                        <textarea id="motivo" class="form-control" required placeholder="Motivo..." cols="30" rows="2"></textarea>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light" center>
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cancelar
                </button>
                
                <button class="btn btn-danger w-100px" id="boton-eliminar-pedido">
                    Eliminar
                </button>
            </div>

        </div>
    </div>
</div>