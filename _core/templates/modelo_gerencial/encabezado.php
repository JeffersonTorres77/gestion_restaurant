<?php
    $objRestaurant = Sesion::getRestaurant();
    $nombreUser = Sesion::getUsuario()->getNombre();
    $nombreRestaurant = $objRestaurant->getNombre();
    $rolUser = Sesion::getUsuario()->getRol()->getNombre();
?>

<div class="w-100 m-0">
    <div class="text-left logo">
        <a href="<?php echo HOST_GERENCIAL."Inicio/"; ?>">
            <img src="<?php echo $objRestaurant->getLogo(); ?>">

            <label class="d-none d-sm-inline-block">
                <?php echo Sesion::getRestaurant()->getNombre(); ?>
            </label>
        </a>
    </div>

    <div class="text-right p-2 opciones-contenedor">
        <?php
            if(Sesion::getUsuario()->getRol()->getResponsable())
            {
                $servicioActivo = Sesion::getRestaurant()->getServicio();
                $textButtonServicio = ($servicioActivo) ? 'Servicio activo' : 'Servicio no activo';
                $backgroundButtonServicio = ($servicioActivo) ? 'bg-success' : 'bg-danger';
                $textTooltip = ($servicioActivo) ? 'Servicio de mesas activo para el publico' : 'Servicio de mesas cerrado para el publico';

                ?>
                    <div class="opciones">
                        <div class="btn-group">
                            <button class="btn btn-sm py-1 order-1 order-lg-0
                                <?php echo $backgroundButtonServicio; ?>"
                                onclick="CambiarServicio()"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="<?php echo $textTooltip; ?>">
                                <i class="fas fa-power-off mr-1"></i>
                                <?php echo $textButtonServicio; ?>
                            </button>
                        </div>
                    </div>
                <?php
            }
        ?>

        <div class="opciones" onclick="MenuLateral()">
            <button class="btn btn-sm order-1 order-lg-0">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="opciones">
            <button class="btn btn-sm order-1 order-lg-0 dropdown-toggle" type="button" data-toggle="collapse" data-target="#data-cuenta-usuario" aria-expanded="false" aria-controls="data-cuenta-usuario">
                <i class="fas fa-user"></i>
            </button>

            <div class="border rounded collapse opciones-data-usuario p-0 shadow-lg" id="data-cuenta-usuario">
                <div class="bg-light py-2 px-3 text-left border-bottom">
                    <div style="font-size: 18px;">
                        <?php echo $nombreUser; ?>
                    </div>

                    <div class="text-muted">
                        <?php echo $nombreRestaurant; ?>
                    </div>

                    <div class="text-muted">
                        <?php echo $rolUser; ?>
                    </div>
                </div>

                <div class="py-2">
                    <a href="<?php echo HOST_GERENCIAL."Cuenta/Datos/"; ?>">
                        <div>
                            <i class="fas fa-user-circle"></i>
                            <span>Datos de la cuenta</span>
                        </div>
                    </a>

                    <div class="border-top my-2"></div>

                    <a href="#">
                        <div onclick="CerrarSesion()">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Cerrar sesión</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="google_translate_element" class="google" style="position: fixed; bottom: 0px; right: 0px;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'ca,eu,gl,en,fr,it,pt,de', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true}, 'google_translate_element');
        }
</script>

<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>