<div class="m-2 p-2">
    <div class="card">
        <div class="card-header position-relative">
            <h5 class="mb-0 card-title">Usuarios administrativos</h5>
        </div>

        <div class="card-body">

            <div class="row mb-2">
                <div class="col-12 col-md-6 justify-content-start mb-2 mb-md-0">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-nuevo">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-md-6 justify-content-start">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="boton-buscador">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <input type="search" name="buscador" id="input-buscador" class="form-control" placeholder="Buscador...">
                    </div>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead class="table-sm">
                            <tr>
                                <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                                <th ordenar="true" key="cedula" class="w-150px no-movil">Cedula</th>
                                <th ordenar="true" key="usuario" class="w-200px no-movil">Usuario</th>
                                <th class="w-100px">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="100" center>
                                    <h5>. . .</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-nuevo">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white p-3">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form-nuevo" onsubmit="event.preventDefault()">

                    <!-- Nombre -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-100px">Nombre</span>
                        </div>
                        <input type="text" name="nombre" class="form-control">
                    </div>
                    <!-- Fin Nombre -->

                    <!-- Cedula -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-100px">Cedula</span>
                        </div>
                        <input type="number" name="cedula" class="form-control">
                    </div>
                    <!-- Fin Cedula -->

                    <hr>

                    <!-- Usuario -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-100px">Usuario</span>
                        </div>
                        <input type="text" name="usuario" class="form-control">
                    </div>
                    <!-- Fin Usuario -->

                    <!-- Clave -->
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text w-100px">Contraseña</span>
                        </div>
                        <input type="password" name="clave" class="form-control">
                    </div>
                    <!-- Fin Clave -->
                    
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-primary" onclick="Nuevo()">
                    Registrar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white p-3">
                <h5 class="mb-0">Eliminar usuario</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form-eliminar" onsubmit="event.preventDefault()">
                    ¿Esta seguro que desea eliminar al usuario de <b id="text-usuario-eliminar">XYZ</b>?
                    <input type="hidden" name="usuario" id="input-usuario-eliminar">
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