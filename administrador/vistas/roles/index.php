<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Roles de los resturantes</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-12 mb-3 col-md-6 mb-md-0">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        
                        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-nuevo">
                            <i class="fas fa-plus"></i>
                        </button>
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
                    <table class="table table-hover table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="w-auto">Nombre</th>
                                <th class="w-auto">Descripción</th>
                                <th class="w-100px">Responsable</th>
                                <th class="w-150px">opciones</th>
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

<!--===========================================================================
    * Modal nuevo
============================================================================-->
<div class="modal fade" id="modal-nuevo">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">Nuevo Rol</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="form-nuevo">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px mb-3">
                                Nombre
                            </label>
                        </div>

                        <input type="text" class="form-control" name="nombre">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px mb-3">
                                Descripción
                            </label>
                        </div>

                        <input type="text" class="form-control" name="descripcion">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px">
                                Responsable
                            </label>
                        </div>

                        <select class="form-control" name="responsable">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" id="boton-submit-nuevo">
                    Registrar
                </button>
            </div>

        </div>
    </div>
</div>

<!--===========================================================================
    * Modal modificar
============================================================================-->
<div class="modal fade" id="modal-modificar">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="mb-0">Modificar Rol</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="form-modificar">
                    <input type="hidden" name="idRol" id="inputIdRol">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px mb-3">
                                Nombre
                            </label>
                        </div>

                        <input type="text" class="form-control" name="nombre" id="modificar-nombre">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px mb-3">
                                Descripción
                            </label>
                        </div>

                        <input type="text" class="form-control" name="descripcion" id="modificar-descripcion">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text w-100px">
                                Responsable
                            </label>
                        </div>

                        <select class="form-control" name="responsable" id="modificar-responsable">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-success" id="boton-submit-modificar">
                    Modificar
                </button>
            </div>
            
        </div>
    </div>
</div>

<!--===========================================================================
    * Modal eliminar
============================================================================-->
<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="mb-0">Eliminar Rol</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="form-eliminar">
                    <input type="hidden" name="idRol" id="eliminar-idRol">
                    <label>
                        ¿Esta seguro que desea eliminar el rol <b id="form-text"></b>?
                    </label>

                    <br>

                    <label>
                        Seleccione un rol, para sustituir al rol que desea eliminar:
                    </label>

                    <select class="form-control" name="idRolSustituir" id="eliminar-idRolSustituir">

                    </select>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-danger" id="boton-submit-eliminar">
                    Eliminar
                </button>
            </div>
            
        </div>
    </div>
</div>

<!--===========================================================================
    * Modal permisos
============================================================================-->
<div class="modal fade" id="modal-permisos">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="mb-0">Permsios de Rol</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="idRol" id="permisos-idRol">
                <table class="table table-striped table-bordered table-hover table-sm mb-0">
                    <thead>
                        <tr>
                            <th class="w-auto">Nombre</th>
                            <th class="w-100px">Permiso</th>
                        </tr>
                    </thead>

                    <tbody id="permisos-tbody">
                        <tr>
                            <td colspan="2">
                                <h5 center class="mb-0 p-3">
                                    . . .
                                </h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>
            </div>
            
        </div>
    </div>
</div>