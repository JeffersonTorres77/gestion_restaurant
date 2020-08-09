<?php
    $objRestaurant = Sesion::getRestaurant();
?>

<script>
    const AREA = 'PUBLIC';
    const MODULO = "menus";
    const ARCHIVO = "index";
    const KEY = '<?php echo Sesion::getKey(); ?>';
</script>

<div class="card card-header sub-header">
    <h5 class="mb-0 d-flex align-items-center">
        <a href="<?php echo HOST."Welcome/"; ?>">
            <div class="float-right">
                <div class="pr-2">
                    <i class="fas fa-sm fa-arrow-left"></i>
                </div>
            </div>
        </a>

        Menus

        <div class="position-absolute" style="right: 5px;">
            <button class="btn btn-outline-primary" onclick="Actualizar()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </h5>
</div>

<div class="m-especial p-2" id="contenedor-combos"></div>