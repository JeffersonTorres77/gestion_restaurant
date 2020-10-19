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

<style>
    .header-opciones .header-opcion {
        text-align: left;
        padding: 10px 15px;
        color: #323232;
        cursor: pointer;
    }

    .header-opciones .header-opcion:hover {
        background-color: rgba(0,0,0,0.1);
    }
</style>

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
        <div class="opciones" id="contenedor-pedidos" <?php echo ($cantidadPedidos > 0) ? "cantidad='{$cantidadPedidos}'" : ''; ?>>
            <button class="btn btn-sm order-1 order-lg-0" onclick="VerPedidos()">
                <i class="fas fa-clipboard-check"></i>
                <span class="ml-2">Pedidos</span>
            </button>
        </div>

        <div class="opciones">
            <button class="btn btn-sm order-1 order-lg-0 dropdown-toggle" data-toggle="collapse" data-target="#container-llamados">
                Llamar
            </button>

            <div id="container-llamados" class="collapse position-absolute" style="width: 200px; top: calc(100% + 2px); right: 0px;">
                <div class="card">
                    <div class="card-body px-0 py-1">
                        <div class="header-opciones">
                            <div class="header-opcion" id="header-option-camarero" onclick="ClienteLlamarCamarero()">
                                <i class="fas fa-bell mr-2"></i>
                                Llamar camarero
                            </div>

                            <div class="header-opcion" id="header-option-cuenta" onclick="ClienteSolicitarCuenta()">
                                <i class="fas fa-book-open mr-2"></i>
                                Solicitar cuenta
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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