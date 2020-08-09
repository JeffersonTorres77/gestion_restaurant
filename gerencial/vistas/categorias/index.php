<?php
    $objRestaurant = Sesion::getRestaurant();
?>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Gestión de Categorías</h5>
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
                        <button class="btn btn-outline-primary" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevaCat">
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
                                <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                                <th ordenar="true" key="idAreaMonitoreo" class="w-150px">Atiende</th>
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
 <div class="modal fade" id="staticBackdropnuevaCat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">   
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="staticBackdropLabel">Nueva Categoría.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        	<form id="form-nuevo"  onsubmit="event.preventDefault()" >
        		<div class="form-row">
              <div class="form-group col-md-12">
                <label for="NombreCategoria">Nombre</label>
                <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria" placeholder="Categoría" required>     
              </div>
				    
              <div class="form-group col-md-12">
                <label for="EnviaCategoria">Atendido Por</label>
                <select class="form-control" id="EnviaCategoria" name="EnviaCategoria">
                  <?php
                    $areas = AreasMonitoreoModel::Listado();
                    foreach($areas as $area)
                    {
                      ?>
                        <option value="<?php echo $area['idAreaMonitoreo']; ?>">
                          <?php echo $area['nombre']; ?>
                        </option>
                      <?php
                    }
                  ?>
                </select>
              </div>
				    </div>
        	</form>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Agregar()">Guardar Datos</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Para Modificar.. -->
<div class="modal fade" id="staticBackdropmodificaCat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header modal-header bg-warning">
        <h5 class="modal-title" id="staticBackdropLabel">Modificar Categoría.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form id="form-modificar">
              <input type="hidden" name="idCategoria" id="MIdCategoria">

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="NombreCategoria">Categoría</label>
                  <input type="text" class="form-control" id="MNombreCategoria" name="NombreCategoria" placeholder="Categoría">
                </div>
                  
                <div class="form-group col-md-12">
                    <label for="EnviaCategoria">Atendido Por</label>
                    <select class="form-control" id="MEnviaCategoria" name="EnviaCategoria">
                      <?php
                        $areas = AreasMonitoreoModel::Listado();
                        foreach($areas as $area)
                        {
                          ?>
                            <option value="<?php echo $area['idAreaMonitoreo']; ?>">
                              <?php echo $area['nombre']; ?>
                            </option>
                          <?php
                        }
                      ?>
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
<div class="modal fade" id="staticBackdropeliminaCat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Categoría.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="form-eliminar">
            <input type="hidden" name="idCategoria" id="EIdCategoria">
            <label id="EText">. . .</label>

            <br><br>

            <label>Seleccione una categoria de reemplazo</label>
            <select name="EIdCategoriaReemplazo" class="form-control">
              <?php
                $condicional = "idRestaurant = '{$objRestaurant->getId()}'";
                $categorias = CategoriasModel::Listado($condicional);
                foreach($categorias as $categoria)
                {
                  ?>
                    <option value="<?php echo $categoria['idCategoria']; ?>">
                      <?php echo $categoria['nombre']; ?>
                    </option>
                  <?php
                }
              ?>
            </select>
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