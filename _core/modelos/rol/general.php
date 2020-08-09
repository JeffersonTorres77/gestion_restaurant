<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de ROL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RolesModel
{
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($idRestaurant)
	{
		$idRestaurant = (int) $idRestaurant;
		$query = "SELECT * FROM roles WHERE idRestaurant = '{$idRestaurant}' ORDER BY idRol ASC";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
	}
	
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Existe($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) AS cantidad FROM roles WHERE idRol = '{$idRol}'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }
	
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function ExisteNombre($idRestaurant, $nombre)
	{
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);

		$query = "SELECT COUNT(*) AS cantidad FROM roles WHERE idRestaurant = '{$idRestaurant}' AND nombre = '{$nombre}'";
		$datos = Conexion::getMysql()->Consultar($query);
		$cantidad = $datos[0]['cantidad'];

		if($cantidad > 0) return TRUE;
		else return FALSE;
	}

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Registrar($idRestaurant, $nombre, $descripcion, $responsable = FALSE)
	{
		$idRol = Conexion::getMysql()->nextID("roles", "idRol");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);
		$descripcion = Filtro::General($descripcion);
		$responsable = boolval( $responsable );
		$fecha_registro = Time::get();

		$query = "INSERT INTO roles (idRol, idRestaurant, nombre, descripcion, responsable, fecha_registro) VALUES ('{$idRol}', '{$idRestaurant}', '{$nombre}', '{$descripcion}', '{$responsable}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un problema al intentar agregar el nuevo rol.");
		}

		$objRol = new RolModel($idRol);
		return $objRol;
	}
}