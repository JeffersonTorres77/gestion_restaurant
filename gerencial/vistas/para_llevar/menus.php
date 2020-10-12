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
                <a class="text-center text-sm-left nav-link" id="v-pills-cuenta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/"; ?>">Cuenta</a>
                <a class="text-center text-sm-left nav-link active" id="v-pills-combo-tab">Menus</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-carta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Carta/"; ?>">Carta</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-espera-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Espera/"; ?>">En espera</a>
            </div>
        </div>

        <div class="col-12 col-sm-10 pl-2 pr-0 m-0">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h5 class="mb-0">
                        Menus y promociones

                        <div class="position-absolute" style="top: 0px; right: 0px;">
                            <div class="text-primary boton" onclick="Actualizar()">
                                <i class="fas fa-xs fa-sync-alt"></i>
                            </div>
                        </div>
                    </h5>
                </div>
            </div>

            <div class="m-especial py-2" id="contenedor-combos"></div>
        </div>
    </div>
</div>