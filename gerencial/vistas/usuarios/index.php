<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Usuarios de los resturantes</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-12 mb-3 col-md-6 mb-md-0">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        
                        <a class="btn btn-outline-primary" href="<?php echo HOST_GERENCIAL."Usuarios/Nuevo/"; ?>">
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

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary rounded-right" data-toggle="collapse" data-target="#filtros">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>

                        <div class="div-flotante">
                            <div class="card w-100 collapse" id="filtros">
                                <h5 class="card-header">Filtros</h5>

                                <div class="card-body">
                                    <form id="form-filtro" onsubmit="event.preventDefault()">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-100px">Usuario</span>
                                            </div>
                                            <input type="text" name="usuario" class="form-control">
                                        </div>

                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-100px">Nombre</span>
                                            </div>
                                            <input type="text" name="nombre" class="form-control">
                                        </div>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-100px">Activo</span>
                                            </div>
                                            <select name="activo" class="form-control">
                                                <option value="">General</option>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <div center class="card-footer">
                                    <button class="btn btn-outline-secondary w-100px" data-toggle="collapse" data-target="#filtros">Cerrar</button>
                                    <button class="btn btn-primary w-100px" id="boton-filtro">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-sm">
                            <tr>
                                <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                                <th ordenar="true" key="usuario" class="w-150px">Usuario</th>
                                <th ordenar="true" key="idRol" class="w-150px">Rol</th>
                                <th class="w-50px">Activo</th>
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

<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white p-3">
                <h5 class="mb-0">Eliminar Usuario</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body bg-light">
                <form id="form-eliminar" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idUsuario" id="input-eliminar-usuario">
                    <label id="text-eliminar">...</label>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-danger" onclick="Eliminar()">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>