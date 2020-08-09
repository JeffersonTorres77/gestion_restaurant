<?php
  $objRestaurant = Sesion::getRestaurant();

  $combos = CombosModel::ListadoCliente( $objRestaurant->getId() );
  $cantidadCombos = sizeof($combos);


  $platos = PlatosModel::ListadoCliente( $objRestaurant->getId() );
  $cantidadPlatos = sizeof($platos);
?>

<script>
    const AREA = 'PUBLIC';
    const MODULO = "welcome";
    const ARCHIVO = "index";
    const KEY = '<?php echo Sesion::getKey(); ?>';
</script>

<div class="container py-2">
  <h2><?php echo "Bienvenido a {$objRestaurant->getNombre()} Online"; ?></h2>
  <br>
  <br>
  <div class="row">
    <div class="col-sm-6">
      <div class="card border-primary mb-3 h-100" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4 p-1">
              <img src="<?php echo $objRestaurant->getimagencomanda(); ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body text-primary">
                <h5 class="card-title"><?php echo $objRestaurant->gettitulocomanda(); ?></h5>
                <p class="card-text"><?php echo $objRestaurant->gettextocomanda(); ?></p>
                <a href="<?php echo HOST."Carta/"; ?>" class="btn btn-outline-primary">Ver Carta</a>
                <p class="card-text">
                  <small class="text-muted">
                    <?php echo "Contamos con {$cantidadPlatos} Platos"; ?>
                  </small>
                </p>
              </div>
            </div>
        </div> 
      </div>
    </div>

    <div class="col-sm-6">
      <div class="card border-primary mb-3 h-100" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4 p-1">
              <img src="<?php echo $objRestaurant->getimagencombo(); ?>" class="card-img" alt="...">
            </div>
            
            <div class="col-md-8">
              <div class="card-body text-primary">
                <h5 class="card-title"><?php echo $objRestaurant->gettitulocombo(); ?></h5>
                <p class="card-text"><?php echo $objRestaurant->gettextocombo(); ?></p>

                <a href="<?php echo HOST."Menus/"; ?>" class="btn btn-outline-primary">Ver Menus</a>
                <p class="card-text">
                  <small class="text-muted">
                    <?php echo "Tenemos {$cantidadCombos} combos"; ?>
                  </small>
                </p>
              </div>
            </div>
        </div> 
      </div>
    </div>
  </div>
</div>