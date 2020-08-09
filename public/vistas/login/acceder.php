<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Inicio de sesión
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$idRestaurant = Input::POST("code");
$usuario = Input::POST("usuario");
$clave = Input::POST("clave");

/*================================================================================
 * Verificamos Restaurant, Usuario y contraseña
================================================================================*/
$objRestaurant = new RestaurantModel( $idRestaurant );
$objMesa = MesasModel::BuscarPorUsuario($idRestaurant, $usuario);

if($objMesa->getClave() != $clave) {
    throw new Exception("Contraseña incorrecta");
}

/*================================================================================
 * Validamos el usuario y la contraseña
================================================================================*/
if($objMesa->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("La mesa <b>{$objMesa->getUsuario()}</b> no pertece al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

if($objMesa->getStatus() == "CERRADA") {
    throw new Exception("Esta mesa esta cerrada.");
}

/*================================================================================
 * Iniciamos la sesión
================================================================================*/
Sesion::CrearCliente($objRestaurant->getId(), $objMesa->getUsuario());
Conexion::getMysql()->Commit();