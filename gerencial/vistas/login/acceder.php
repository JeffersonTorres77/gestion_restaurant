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
$objUsuario = UsuariosModel::BuscarPorUsuario($idRestaurant, $usuario);

if($objUsuario->getClave() != $clave) {
    throw new Exception("Contraseña incorrecta");
}

/*================================================================================
 * Validamos que tanto el usuario como restaurant esten activos
================================================================================*/
if($objRestaurant->getActivo() === FALSE) {
    throw new Exception("EL restaurant <b>".$objRestaurant->getNombre()."</b> no esta activo.");
}

if($objUsuario->getActivo() === FALSE) {
    throw new Exception("EL usuario <b>".$objUsuario->getNombre()."</b> no esta activo.");
}

/*================================================================================
 * Iniciamos la sesión
================================================================================*/
Sesion::Crear($objRestaurant->getId(), $objUsuario->getId());