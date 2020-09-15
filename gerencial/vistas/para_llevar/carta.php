<?php
    $objRestaurant = Sesion::getRestaurant();
    $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
?>

<div class="p-2 m-2">
    <div class="row p-0 m-0">
        <div class="col-12 col-sm-2 p-0 m-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" aria-orientation="vertical">
                <a class="text-center text-sm-left nav-link" id="v-pills-cuenta-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/"; ?>">Cuenta</a>
                <a class="text-center text-sm-left nav-link" id="v-pills-combo-tab" href="<?php echo HOST_GERENCIAL."Para_Llevar/Menus/"; ?>">Menus</a>
                <a class="text-center text-sm-left nav-link active" id="v-pills-carta-tab">Carta</a>
            </div>
        </div>

        <div class="col-12 col-sm-10 pl-2 pr-0 m-0">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h5 class="mb-0 d-flex align-items-center">
                        Comanda

                        <div class="position-absolute" style="right: 5px;">
                            <div class="input-group input-group-sm w-150px">
                                <select class="form-control" onchange="CambioCategoria(this)" id="select-carta-categoria">
                                    <option value="">General</option>
                                    <?php
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
                        </div>
                    </h5>
                </div>
            </div>

            <div class="m-especial py-2" id="contenedor-platos"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ver">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-img">
                <img src="" id="campo-ver-img" alt=". . .">
            </div>

            <div class="modal-header py-2 px-3">
                <div class="mb-0">
                    <div id="campo-ver-nombre" class="h5 mb-0"></div>
                    <div id="campo-ver-categoria" class="text-muted h6 mb-0"></div>
                </div>
            </div>

            <div class="modal-body">
                <form id="form-ver" onsubmit="event.preventDefault()">
                        <input type="hidden" name="idPlato" id="campo-ver-id">

                    <div class="mb-3">
                        Descripción:<br>
                        <div id="campo-ver-descripcion" class="p-2 bg-light border rounded"></div>
                    </div>
                    <div id="campo-ver-precio" class="mb-3 h4 text-primary font-weight-bold"></div>

                    <hr>

                    <div class="form-group">
                        <label for="campo-ver-cantidad" class="mb-0">Cantidad:</label>
                        <select required class="form-control" id="campo-ver-cantidad" name="cantidad">
                            <?php
                                for($I=1; $I<=10; $I++)
                                {
                                    ?>
                                        <option><?php echo $I; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label for="campo-ver-observaciones" class="mb-0">Nota:</label>
                        <textarea class="form-control" id="campo-ver-observaciones" name="observaciones" placeholder="Nota..." cols="30" rows="3"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-primary" onclick="ConfirmarPedido()">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>