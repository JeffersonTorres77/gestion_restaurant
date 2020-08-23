<style>
    .div-imagen
    {
        text-align: center;
    }

    @media (min-width: 992px)
    {
        .div-imagen
        {
            width: 172px;
        }
    }
</style>

<div class="m-2 p-2">
    <form class="card" id="form-servicio" onsubmit="event.preventDefault()">
        <div class="card-header">
            <h5 class="mb-0">
                Servicio

                <a href="#more-info" data-toggle="collapse">
                    <div class="float-right px-2">
                        <i class="fas fa-xs fa-info"></i>
                    </div>
                </a>
            </h5>

            <div class="collapse" id="more-info">
                <div class="mt-2">
                    <b>Documento:</b> <?php echo $objRestaurant->getDocumento(); ?><br>
                </div>

                <div class="text-muted">
                    <b>Registro:</b> <?php echo Formato::Fecha( $objRestaurant->getFechaRegistro() ); ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row justify-content-center">
                <!-- inicio de la tarjeta de comandas -->
                <div class="col-12 col-md-6 mb-3">    
                    <div class="card border-primary h-100">
                        <div class="d-block d-md-flex no-gutters">
                            <div class="p-3 div-imagen">
                                <input type="file" id="img-comanda-restaurant" class="d-none" accept="image/*" name="imgComanda">
                                <label class="logo-muestra border-secondary bg-light mb-0" tabindex="0" for="img-comanda-restaurant" id="label-imgcomanda-restaurant">
                                    <img src="<?php echo $objRestaurant->getimagencomanda(); ?>">
                                </label>
                            </div>

                            <div class="w-100">
                                <div class="card-body text-primary">
                                    <div class="form group mb-3">
                                        <label class="mb-1" for="input-titulo-comanda">Título Comanda</label>
                                        <input type="text" id="input-titulo-comanda" name="titulocomanda" class="form-control" value="<?php echo $objRestaurant->gettitulocomanda(); ?>">
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="mb-1" for="input-texto-comanda">Texto Comanda</label>
                                        <textarea id="input-texto-comanda" name="textocomanda" class="form-control" cols="30" rows="4"><?php echo $objRestaurant->gettextocomanda(); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- fin de la tarjeta de comandas    -->

                <!-- inicio de la tarjeta de combos -->
                <div class="col-12 col-md-6 mb-3">    
                    <div class="card border-primary h-100">
                        <div class="d-block d-md-flex no-gutters">
                            <div class="p-3 div-imagen">
                                <input type="file" id="img-combo-restaurant" class="d-none" accept="image/*" name="imgCombo">
                                <label class="logo-muestra border-secondary bg-light mb-0" tabindex="0" for="img-combo-restaurant" id="label-imgcombo-restaurant">
                                    <img src="<?php echo $objRestaurant->getimagencombo(); ?>">
                                </label>
                            </div>
                            
                            <div class="w-100">
                                <div class="card-body text-primary">
                                    <label class="mb-0" for="input-titulo-comanda">Título menu</label>
                                    <input type="text" id="input-titulo-combo" name="titulocombo" class="form-control" value="<?php echo $objRestaurant->gettitulocombo(); ?>">
                                    <label class="mb-0" for="input-texto-combo">Texto menu</label>
                                    <textarea id="input-texto-combo" name="textocombo" class="form-control" cols="30" rows="4"><?php echo $objRestaurant->gettextocombo(); ?></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- fin de la tarjeta de combos    --> 
            </div>
        </div>

        <div class="card-footer" center>
            <button type="reset" class="btn btn-outline-secondary w-100px">Limpiar</button>
            <button type="submit" class="btn btn-primary w-100px">Guardar</button>
        </div>
    </form>
</div>