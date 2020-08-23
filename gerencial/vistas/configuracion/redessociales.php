<div class="m-2 p-2">
    <form class="card" id="form-redes" onsubmit="event.preventDefault()">
        <div class="card-header">
            <h5 class="mb-0">
                Redes sociales

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
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-whatsapp">Whatsapp</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fab fa-whatsapp"></i>
                                </span>
                            </div>
                            <input type="tel" name="whatsapp" id="input-basico-whatsapp" class="form-control" value="<?php echo $objRestaurant->getWhatsapp(); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-instagram">Instagram</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fab fa-instagram"></i> </span>
                                <span class="input-group-text"> instagram.com/ </span>
                            </div>
                            <input type="text" name="instagram" id="input-basico-instagram" class="form-control" value="<?php echo $objRestaurant->getInstagram(); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-twitter">Twitter</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fab fa-twitter"></i> </span>
                                <span class="input-group-text"> twitter.com/ </span>
                            </div>
                            <input type="text" name="twitter" id="input-basico-twitter" class="form-control" value="<?php echo $objRestaurant->getTwitter(); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mb-0" for="input-basico-facebook">Facebook</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fab fa-facebook-f"></i> </span>
                                <span class="input-group-text"> facebook.com/ </span>
                            </div>
                            <input type="text" name="facebook" id="input-basico-facebook" class="form-control" value="<?php echo $objRestaurant->getFacebook(); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer" center>
            <button type="reset" class="btn btn-outline-secondary w-100px">Limpiar</button>
            <button type="submit" class="btn btn-primary w-100px">Guardar</button>
        </div>
    </form>
</div>