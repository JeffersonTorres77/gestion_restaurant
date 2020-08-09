<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Restaurantes</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-12 mb-2 col-md-6 mb-md-0">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" id="boton-actualizar" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                        <a class="btn btn-outline-primary" href="<?php echo HOST_ADMIN."Restaurantes/Registrar/"; ?>">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="boton-buscador">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <input type="search" class="form-control" placeholder="Buscar..." id="input-buscador">
                    </div>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-sm">
                            <tr>
                                <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                                <th ordenar="true" key="documento" class="w-150px no-table">Documento</th>
                                <th class="w-100px">Activo</th>
                                <th class="w-100px">opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="100">
                                    <h2 center>. . .</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-cambiar-acceso">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-warning p-3">
                <h5 class="mb-0">Cambiar acceso a restaurant</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form-cambiar-acceso">
                    <input type="hidden" name="idRestaurant" id="id-cambiar-acceso">
                    <label id="label-cambiar-acceso">...</label>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-warning" onclick="ModificarAcceso()">
                    Seguro
                </button>
            </div>

        </div>
    </div>
</div>