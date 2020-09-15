<style>
    .boton {
        cursor: pointer;
        transition-duration: .2s;
        padding: 11px 15px;
        height: 100%;
        border-left: 1px solid rgba(0,0,0,0);
    }

    .boton:hover {
        background: rgba(0,0,0,0.07);
        border-color: rgba(0,0,0,0.125);
    }
</style>

<div class="p-2 m-2">
    <div class="row p-0 m-0">
        <div class="col-12 col-sm-2 p-0 m-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" aria-orientation="vertical">
                <a class="text-center text-sm-left nav-link active" id="v-pills-cuenta-tab">Cuenta</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-combo-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Menus/"; ?>">Menus</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-carta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Carta/"; ?>">Carta</a>
            </div>
        </div>

        <div class="col-12 col-sm-10 pl-2 pr-0 m-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Cuenta

                        <div class="position-absolute" style="top: 0px; right: 0px;">
                            <div class="text-primary boton" id="boton-actualizar-cuenta">
                                <i class="fas fa-xs fa-sync-alt"></i>
                            </div>
                        </div>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered mb-0">
                            <thead class="table-sm">
                                <tr>
                                    <th style="width: 35px;"></th>
                                    <th class="w-auto">Descripción</th>
                                    <th class="w-150px">N° factura</th>
                                    <th class="w-100px">Status</th>
                                    <th class="w-50px">Cantidad</th>
                                    <th class="w-150px">Total</th>
                                </tr>
                            </thead>

                            <tbody id="tbody-cuenta">
                                <tr>
                                    <td colspan="100">
                                        <h5 center>. . .</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer" center>
                    <button class="btn btn-primary w-100px" id="boton-pagar" disabled>
                        Pagar
                    </button>

                    <button class="btn btn-success w-100px" id="boton-listo" disabled onclick="ModalMigrar()">
                        ¡Listo!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-pagar">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">
                    Facturar pedidos
                </h5>

                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="form-pagar">
                    <div class="form-group mb-0">
                        <label class="mb-0">Numero de factura:</label>
                        <input type="number" name="numero_factura" id="pagar-numero_factura" class="form-control" required placeholder="Numero de factura...">
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" onclick="Pagar()">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-listo">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="mb-0">
                    Entrega de pedidos
                </h5>

                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                ¿Esta seguro que desea confirmar la entrega de los pedidos?
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-success" onclick="Migrar()">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>