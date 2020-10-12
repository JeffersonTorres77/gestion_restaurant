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

foreach($categorias as $categoria)
{
    $datos = PlatosModel::ListadoCliente( $objRestaurant->getId(), $categoria['idCategoria'] );
    $platos = [];

    foreach($datos as $dato)
    {
        $objPlato = new PlatoModel($dato['idPlato']);

        array_push($platos, [
            "id" => $objPlato->getId(),
            "categoria" => [
                "id" => $categoria['idCategoria'],
                "nombre" => $categoria['nombre']
            ],
            "nombre" => $objPlato->getNombre(),
            "descripcion" => $objPlato->getDescripcion(),
            "imagen" => $objPlato->getImagen(),
            "precio" => $objPlato->getPrecioVenta()
        ]);
    }

    array_push($data['categorias'], [
        "id" => $categoria['idCategoria'],
        "nombre" => $categoria['nombre'],
        "platos" => $platos
    ]);
}

$respuesta['cuerpo'] = $data;