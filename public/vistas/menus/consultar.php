<?php

$objRestaurant = Sesion::getRestaurant();
$data['combos'] = [];

$combos = CombosModel::ListadoCliente( $objRestaurant->getId() );
foreach($combos as $combo)
{
    $objCombo = new ComboModel( $combo['idCombo'] );

    array_push($data['combos'], [
        "id" => $objCombo->getId(),
        "nombre" => $objCombo->getNombre(),
        "imagen" => $objCombo->getImagen(),
        "descripcion" => $objCombo->getDescripcion(),
        "descuento" => $objCombo->getDescuento()
    ]);
}

$respuesta['cuerpo'] = $data;