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

    .sombra {
        cursor: pointer;
        transition-duration: .2s;
    }
    .sombra:hover {
        box-shadow: 1px 1px 5px 0px black;
    }
</style>

<div class="p-2 m-2">
    <div class="row p-0 m-0">
        <div class="col-12 col-sm-2 p-0 m-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" aria-orientation="vertical">
                <a class="text-center text-sm-left nav-link" id="v-pills-cuenta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/"; ?>">Cuenta</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-combo-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Menus/"; ?>">Menus</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-carta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Carta/"; ?>">Carta</a>
                <a class="text-center text-sm-left nav-link active" id="v-pills-espera-tab">En espera</a>
            </div>
        </div>

        <div class="col-12 col-sm-10 pl-2 pr-0 m-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        En espera

                        <div class="position-absolute" style="top: 0px; right: 0px;">
                            <div class="text-primary boton" id="boton-actualizar-cuenta">
                                <i class="fas fa-xs fa-sync-alt"></i>
                            </div>
                        </div>
                    </h5>
                </div>

                <div class="card-body">
                    <div id="contenedor" class="row">
                        <div class="col-12 p-0 px-3">
                            <div class="card bg-light">
                                <div class="card-body" center>
                                    <h5>. . .</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer" center>
                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-entrega">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">
                    Entrega de pedidos
                </h5>

                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <label id="label-entrega">¿Esta seguro que desea confirmar la entrega de los pedidos?</label>
                <form id="form-entrega">
                    <input type="hidden" name="loteOrden" id="loteOrden-entrega">
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" onclick="Entregar()">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>