<?php
    $nombreUser = Sesion::getUsuario()->getNombre();
    $ciUser = Sesion::getUsuario()->getCedula();
?>

<div class="w-100 m-0">
    <div class="text-left logo">
        <a href="<?php echo HOST_ADMIN."Inicio/"; ?>">
            <img src="<?php echo HOST."recursos/core/img/logotipo.png"; ?>">

            <label class="d-none d-sm-inline-block">
                <?php echo SISTEMA_NOMBRE; ?>
            </label>
        </a>
    </div>

    <div class="text-right p-2 opciones-contenedor">
        <div class="opciones">
            <button class="btn btn-sm order-1 order-lg-0" onclick="MenuLateral()">
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
                        <?php echo $ciUser; ?>
                    </div>
                </div>

                <div class="py-2">
                    <a href="<?php echo HOST_ADMIN."Cuenta/Datos/"; ?>">
                        <div>
                            <i class="fas fa-user-circle"></i>
                            <span>Datos de la cuenta</span>
                        </div>
                    </a>

                    <div class="border-top my-2"></div>

                    <a>
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