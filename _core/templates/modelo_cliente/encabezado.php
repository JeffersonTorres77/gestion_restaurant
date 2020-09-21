<?php
    $objRestaurant = Sesion::getRestaurant();
    $objMesa = Sesion::getUsuario();

    $nombreMesa = $objMesa->getAlias();
    $nombreRestaurant = $objRestaurant->getNombre();

    if( $objRestaurant->getStatusServicio() ) {
        Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );
        $pedidos = PedidosDetallesClienteModel::SinConfirmar( $objRestaurant->getId(), $objMesa->getId() );
        $cantidadPedidos = sizeof( $pedidos );
    } else {
        $cantidadPedidos = 0;
    }
?>

<div class="w-100 m-0">
    <div class="text-left logo">
        <a href="<?php echo HOST."Welcome/"; ?>">
            <img src="<?php echo $objRestaurant->getLogo(); ?>">

            <label class="d-none d-sm-inline-block">
                <?php echo Sesion::getRestaurant()->getNombre(); ?>
            </label>
        </a>
    </div>

    <div class="text-right p-2 opciones-contenedor">
        <div class="opciones">
            <button class="btn btn-sm" id="boton-camarero" onclick="LlamarCamarero()">
                <i class="fas fa-bell"></i>
                <span class="ml-2">Camarero</span>
            </button>
        </div>

        <div class="opciones" id="contenedor-pedidos" <?php echo ($cantidadPedidos > 0) ? "cantidad='{$cantidadPedidos}'" : ''; ?>>
            <button class="btn btn-sm order-1 order-lg-0" onclick="VerPedidos()">
                <i class="fas fa-clipboard-check"></i>
                <span class="ml-2">Pedidos</span>
            </button>
        </div>

        <div class="opciones" onclick="MenuLateral()">
            <button class="btn btn-sm order-1 order-lg-0">
                <i class="fas fa-bars"></i>
            </button>
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