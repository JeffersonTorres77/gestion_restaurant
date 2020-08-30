<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">Pedidos por categorias</h5>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 mb-2 col-md-6 mb-md-0">
                    <!--Asignamos el evento de actualizar aqui -->
                    <button class="btn btn-outline-primary" id="boton-actualizar" onclick="Actualizar()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="boton-buscador">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <input type="search" class="form-control" placeholder="Nombre..." id="input-buscador">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary rounded-right" data-toggle="collapse" data-target="#filtros">
                                <i class="fas fa-angle-down"></i>
                            </button>
                        </div>

                        <div class="position-absolute w-100 collapse" id="filtros" style="top: calc(100% + 3px); z-index: 5;">
                            <form class="card" onsubmit="event.preventDefault()" id="form-filtro">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        Filtros
                                        <button class="close" type="button" data-toggle="collapse" data-target="#filtros">&times;</button>
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text mb-0 w-100px">Nombre</label>
                                        </div>

                                        <input type="text" class="form-control" name="nombre">
                                    </div>

                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text mb-0 w-100px">Fecha</label>
                                        </div>

                                        <input type="date" class="form-control" name="fecha-inicio">
                                        <input type="date" class="form-control" name="fecha-fin">
                                    </div>
                                </div>

                                <div class="card-footer" center>
                                    <button class="btn btn-outline-secondary w-100px" type="reset">
                                        Limpiar
                                    </button>

                                    <button class="btn btn-primary w-100px" type="button" id="boton-filtro">
                                        Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered m-0 table-sm">
                        <thead>
                            <tr>
                                <th ordenar="true" key="nombre" class="w-auto">Categoria</th>
                                <th ordenar="true" key="cantidad" class="w-100px">Cantidad</th>
                                <th ordenar="true" key="ingresos" class="w-200px">Ingresos</th>
                            </tr>
                        </thead>

                        <tbody id="tbody-elementos">
                            <tr>
                                <td colspan="100" center>
                                    <h5 class="m-0 p-2">. . .</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>