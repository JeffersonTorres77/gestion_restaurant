<script>
    const AREA = 'PUBLIC';
    const MODULO = "cuenta";
    const ARCHIVO = "index";
    const KEY = '<?php echo Sesion::getKey(); ?>';
</script>

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

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header position-relative">
            <h5 class="m-0">
                <div class="float-left">
                    <a href="<?php echo HOST . "Welcome/"; ?>">
                        <i class="fas fa-sm fa-arrow-left mr-2"></i>
                    </a>
                </div>

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
                            <th class="w-auto">Descripción</th>
                            <th class="w-100px">Status</th>
                            <th class="w-150px">Precio</th>
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
            <button class="btn btn-primary w-150px" id="boton-llamarCamarero">
                Llamar camarero
            </button>
        </div>
    </div>
</div>