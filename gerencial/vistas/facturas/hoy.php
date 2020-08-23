<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Facturas de hoy</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-12 mb-3 col-md-6 mb-md-0">
                    <button class="btn btn-outline-primary" onclick="Actualizar()">
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

                        <input type="search" class="form-control" placeholder="Numero..." id="input-buscador">

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
                                                <span class="input-group-text w-100px">Numero</span>
                                            </div>
                                            <input type="text" name="numero" class="form-control">
                                        </div>

                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-100px">Total</span>
                                            </div>
                                            <input type="number" name="total-inicio" class="form-control" placeholder="Total inferior">
                                            <input type="number" name="total-fin" class="form-control" placeholder="Total superior">
                                        </div>

                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text w-100px">Hora</span>
                                            </div>
                                            <input type="time" name="hora-inicio" class="form-control">
                                            <input type="time" name="hora-fin" class="form-control">
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
                                <th ordenar="true" key="numero" class="w-auto">Numero</th>
                                <th ordenar="true" key="total" class="w-150px">Total</th>
                                <th class="w-50px">Items</th>
                                <th ordenar="true" key="hora" class="w-100px">Hora</th>
                                <th class="w-50px">Opciones</th>
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