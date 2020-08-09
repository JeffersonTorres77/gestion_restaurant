<?php
    $objRestaurant = Sesion::getRestaurant();
    $servicio = $objRestaurant->getServicio();
?>
<div class="m-2 p-2">
    <?php
      if( $servicio )
      {
        ?>
          <div class="alert alert-success">
            Servicio activo

            <div class="position-absolute p-2" style="top: 0px; right: 0px;">
              <button class="btn btn-danger btn-sm" onclick="CambiarServicio()">
                <i class="fas fa-power-off"></i>
              </button>
            </div>
          </div>
        <?php
      }
      else
      {
        ?>
          <div class="alert alert-danger">
            Servico no activo

            <div class="position-absolute p-2" style="top: 0px; right: 0px;">
              <button class="btn btn-success btn-sm" onclick="CambiarServicio()">
                <i class="fas fa-power-off"></i>
              </button>
            </div>
          </div>
        <?php
      }
    ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Gestión de Mesas</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-12 mb-2 col-md-6 mb-md-0">
                    <div class="btn-group">
                    	<!--Asignamos el evetno de actualizar aqui -->
                        <button class="btn btn-outline-primary" id="boton-actualizar" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                        <!-- Button trigger modal  Nueva Mesa-->
                        <button class="btn btn-outline-primary" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevaMesa">
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
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-sm">
                            <tr>
                            	<!-- Solo mostraremos estas columnas -->
                                <th ordenar="true" key="alias" class="w-auto">Información de Mesa</th>
                                <th ordenar="true" key="status" class="w-150px">Status</th>
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




<!-- Modal Para Agregar.. -->
<div class="modal fade" id="staticBackdropnuevaMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="staticBackdropLabel">Nueva Mesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
        	<form id="form-nuevo"  onsubmit="event.preventDefault()">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="aliasmesa" class="mb-0">Alias</label> 
                  <input type="text" class="form-control" id="aliasmesa" name="alias" placeholder="Información de Mesa">
                </div>

                <hr>

                <div class="form-group col-md-12 mb-1">
                  <label for="usuariomesa" class="mb-0">Datos de acceso</label> 
                  <input type="text" class="form-control" id="usuariomesa" name="usuario" placeholder="Usuario...">
                </div>

                <div class="form-group col-md-12 mb-0">
                  <input type="text" class="form-control" id="clavemesa" name="clave" placeholder="Contraseña...">
                </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Agregar()">Aceptar</button>
      </div>

    </div>
  </div>
</div>



<!-- Modal Para Modificar Mesas.. -->
<div class="modal fade" id="staticBackdropModificaMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header modal-header bg-warning">
        <h5 class="modal-title" id="staticBackdropLabel">Modifica la Mesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
          <form id="form-modificar">
            <input type="hidden" name="MIdMesa" id="MIdMesa">

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="Maliasmesa" class="mb-0">Alias</label> 
                <input type="text" class="form-control" id="Maliasmesa" name="alias" placeholder="Información de Mesa" required>
              </div>

              <div class="form-group col-md-12 mb-1">
                <label for="Musuario" class="mb-0">Datos de acceso</label> 
                <input type="text" class="form-control" id="Musuario" name="usuario" placeholder="Usuario..." required>
              </div>
              
              <div class="form-group col-md-12">
                <input type="text" class="form-control" id="Mclave" name="clave" placeholder="Contraseña" required>
              </div>

              <div class="form-group col-md-12">
                <label for="Mstatus" class="mb-0">Status</label>
                <select class="form-control" name="status" id="Mstatus" required>
                  <option value="ABIERTA">Abierta</option>
                  <option value="CERRADA">Cerrada</option>
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning" onclick="Modificar()">Modificar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Para Eliminar.. -->
<div class="modal fade" id="staticBackdropeliminaMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Mesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="form-eliminarmesa">
            <input type="hidden" name="EidMesa" id="EidMesa">
            <label id="EText" class="mb-0">. . .</label>
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