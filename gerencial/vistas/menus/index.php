<div class="m-2 p-2">
  <div class="card">
    <div class="card-header">
        <h5 class="mb-0">Gestión de Menus</h5>
    </div>

    <div class="card-body">

      <div class="row mb-3">
          <div class="col-12 mb-2 col-md-6 mb-md-0">
              <div class="btn-group">
                <!--Asignamos el evetno de actualizar aqui -->
                  <button class="btn btn-outline-primary" id="boton-actualizar" onclick="Actualizar()">
                      <i class="fas fa-sync-alt"></i>
                  </button>

                  <!-- Button trigger modal  Nuevo Plato-->
                  <a class="btn btn-outline-primary" href="<?php echo HOST_GERENCIAL."Menus/Registrar/"; ?>">
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
                        <!-- Solo mostraremos estas columnas -->
                          <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                          <th ordenar="true" key="descuento" class="w-50px">Descuento</th>
                          <th class="w-50px">Status</th>
                          <th class="w-50px">Ver</th>
                          <th class="w-50px">Modificar</th>
                          <th class="w-50px">Eliminar</th>
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

<div class="modal fade" id="modal-eliminar" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title mb-0">Eliminar Combo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-eliminar" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idCombo" id="input-idCombo-eliminar">
                    <label class="mb-0">¿Esta seguro que desea eliminar el combo <b id="label-nombre-eliminar">XYZ</b>?</label>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="Eliminar()">Eliminar</button>
            </div>

        </div>
    </div>
</div>