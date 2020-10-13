<div class="m-2 p-2">
  <div class="card">
    <div class="card-header">
        <h5 class="mb-0">Gestión de Platos</h5>
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
                  <button class="btn btn-outline-primary" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevoPla">
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
                          <th ordenar="true" key="categoria" class="w-200px">Categoria</th>
                          <th class="w-50px">Activo</th>
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

<div class="modal fade" id="modal-cambiar-acceso">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white p-3">
                <h5 class="mb-0">Cambiar acceso a restaurant</h5>
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

                <button class="btn btn-dark" id="boton-cambiar-acceso">
                    Seguro
                </button>
            </div>

        </div>
    </div>
</div> 



<!-- Modal Para Agregar.. -->
<div class="modal fade" id="staticBackdropnuevoPla" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Plato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
          <form id="form-nuevo" enctype="multipart/form-data" onsubmit="event.preventDefault()">
            <div class="form-row">
              <div class="col-12">
                <div class="row">

                  <div class="form-group ml-3" center>
                    <input type="file" id="img-foto-plato-nuevo" class="d-none" accept="image/*" name="img">
                    <label class="foto-plato-muestra border-secondary mb-0" tabindex="0" for="img-foto-plato-nuevo" id="label-foto-plato-nuevo">
                      <img src="<?php echo HOST.IMG_PLATO_DEFECTO; ?>">
                    </label>
                  </div>

                  <div class="form-group col">
                    <label for="NombrePlato" class="mb-1">Nombre</label>	
                    <input type="text" class="form-control" id="NombrePlato" name="NombrePlato" placeholder="Nombre del Plato">
                  </div>
                  
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="DescripPlato" class="mb-0">Descripción</label>	
                <textarea class="form-control" id="DescripPlato" name="DescripPlato" rows="3"></textarea>
              </div>

              <div class="form-group col-md-12">
                <label for="CategoriaPlato" class="mb-0">Categoría</label>
                <select class="form-control" id="CategoriaPlato" name="CategoriaPlato">
                  <?php
                    $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
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
              </div>

              <div class="form-group col-md-6">
                <label for="PrecioCostoPlato" class="mb-0">Precio de Costo</label>	
                <input type="number" class="form-control" id="PrecioCostoPlato" name="PrecioCostoPlato" placeholder="Precio Costo">	
              </div>

              <div class="form-group col-md-6">
                <label for="PrecioVentaPlato" class="mb-0">Precio de Venta</label>	
                <input type="number" class="form-control" id="PrecioVentaPlato"name="PrecioVentaPlato" placeholder="Precio Venta">	
              </div>

              <div class="form-group col-md-6">
                <label for="Impuesto" class="mb-0">Impuestos</label>
                <input type="number" class="form-control" id="Impuesto" disabled value="<?php echo $objRestaurant->getIva(); ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="PrecioVentaIva" class="mb-0">Precio de Venta con Impuestos</label> 
                <input type="number" class="form-control" id="PrecioVentaIva" name="PrecioVentaIva" placeholder="Precio con impuestos" value="0">   
              </div>
              
              <div class="custom-control custom-switch">
                <input type="checkbox" checked class="custom-control-input" id="customSwitch1" name="ActivoPlato">
                <label class="custom-control-label" for="customSwitch1">Activo</label>
              </div>

            </div>
          </form>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Agregar()">Aceptar</button>
      </div>

    </div>
  </div>
</div>



<!-- Modal Para Modificar.. -->
<div class="modal fade" id="staticBackdropmodificaPla" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title mb-0" id="staticBackdropLabel">Modificar Plato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="container">
          <form id="form-modificar" enctype="multipart/form-data" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idPlato" id="idPlato-modificar">
              <div class="form-row">

                <div class="col-12">
                  <div class="row">

                    <div class="form-group ml-3" center>
                      <input type="file" id="img-foto-plato-modificar" class="d-none" accept="image/*" name="img">
                      <label class="foto-plato-muestra border-secondary mb-0" tabindex="0" for="img-foto-plato-modificar" id="label-foto-plato-modificar">
                        <img src="<?php echo HOST."recursos/core/img/plato-defecto.png"; ?>">
                      </label>
                    </div>

                    <div class="form-group col">
                      <label for="MNombrePlato" class="mb-1">Nombre</label>	
                      <input type="text" class="form-control" id="MNombrePlato" name="NombrePlato" placeholder="Nombre del Plato">
                    </div>
                    
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <label for="MDescripPlato" class="mb-0">Descripción</label>   
                  <textarea class="form-control" id="MDescripPlato" name="MDescripPlato" rows="3"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="MCategoriaPlato" class="mb-0">Categoría</label>
                    <select class="form-control" id="MCategoriaPlato" name="MCategoríaPlato">
                      <?php
                        $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
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
                </div>

                <div class="form-group col-md-6">
                  <label for="MPrecioCostoPlato" class="mb-0">Precio de Costo</label> 
                  <input type="number" class="form-control" id="MPrecioCostoPlato" name="MPrecioCostoPlato" placeholder="Precio Costo">   
                </div>

                <div class="form-group col-md-6">
                  <label for="MPrecioVentaPlato" class="mb-0">Precio de Venta</label> 
                  <input type="number" class="form-control" id="MPrecioVentaPlato" name="MPrecioVentaPlato" placeholder="Precio Venta">   
                </div>

                <div class="form-group col-md-6">
                  <label for="MPImpuesto" class="mb-0">Impuestos</label>
                  <input type="number" class="form-control" id="MPImpuesto" disabled value="<?php echo $objRestaurant->getIva(); ?>">
                </div>

                <div class="form-group col-md-6">
                  <label for="MPPrecioVentaIva" class="mb-0">Precio de Venta con Impuestos</label> 
                  <input type="number" class="form-control" id="MPPrecioVentaIva" name="MPPrecioVentaIva" placeholder="Precio con impuestos" value="0">   
                </div>
              
                <div class="custom-control custom-switch">
                  <input type="checkbox" checked class="custom-control-input" id="customSwitch2" name="ActivoPlato">
                  <label class="custom-control-label" for="customSwitch2">Activo</label>
                </div>
                    
              </div>
          </form>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning" onclick="Modificar()">Guardar</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modal-eliminar">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title mb-0">Eliminar Plato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="form-eliminar" onsubmit="event.preventDefault()">
          <input type="hidden" name="idPlato" id="idPlato-eliminar">
          <label>¿Esta seguro que desea eliminar el plato <b id="label-eliminar">XYZ</b>?</label>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="Eliminar()">Eliminar</button>
      </div>

    </div>
  </div>
</div>