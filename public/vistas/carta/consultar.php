<?php

$idCategoria = Input::POST("categoria", FALSE);
$objRestaurant = Sesion::getRestaurant();
$data['categorias'] = [];

if($idCategoria === FALSE)
{
    $condicional = "idRestaurant = '{$objRestaurant->getId()}'";
    $categorias = CategoriasModel::Listado($condicional);
}
else
{
    $objCategoria = new CategoriaModel( $idCategoria );
    $condicional = "idRestaurant = '{$objRestaurant->getId()}' AND ";
    $condicional .= "idCategoria = '{$objCategoria->getId()}'";
    $categorias = CategoriasModel::Listado($condicional);
}

$iva = $objRestaurant->getIva();

foreach($categorias as $categoria)
{
    $datos = PlatosModel::ListadoCliente( $objRestaurant->getId(), $categoria['idCategoria'] );
    $platos = [];

    foreach($datos as $dato)
    {
        $objPlato = new PlatoModel($dato['idPlato']);
        $precio = $objPlato->getPrecioVenta() * (1 + ($iva / 100));
        $precio = bcdiv($precio, '1', 2);

        array_push($platos, [
            "id" => $objPlato->getId(),
            "categoria" => [
                "id" => $categoria['idCategoria'],
                "nombre" => $categoria['nombre']
            ],
            "nombre" => $objPlato->getNombre(),
            "descripcion" => $objPlato->getDescripcion(),
            "imagen" => $objPlato->getImagen(),
            "precio" => $precio
        ]);
    }

    array_push($data['categorias'], [
        "id" => $categoria['idCategoria'],
        "nombre" => $categoria['nombre'],
        "platos" => $platos
    ]);
}

$respuesta['cuerpo'] = $data;