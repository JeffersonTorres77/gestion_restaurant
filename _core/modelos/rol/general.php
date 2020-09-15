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
	/**
     * Listado
     * Array(
     *      condicional: string
     *      cantMostrar: number (> 1)
     *      pagina: number (> 0)
     *      ordenar_por: string
     *      ordenar_tipo: string (ASC / DESC)
     *  )
     */
	public static function Listado($condicional, $par = [])
	{
        /**
         * Iniciar
         */
        $order_by = "";
        $where = "";
        $limit = "";

        /**
         * Where
         */
        if($condicional != "")
        {
            $where = "WHERE {$condicional}";
        }

        /**
         * Limit
         */
        if(isset($par['cantMostrar']))
        {
            $cantMostrar = (int) $par['cantMostrar'];
            if($cantMostrar < 1) $cantMostrar = 10;
            if(isset($par['pagina']))
            {
                $pagina = (int) $par['pagina'];
                if($pagina < 1) $pagina = 1;
                $inicio = ($pagina - 1) * $cantMostrar;
                $limit = "LIMIT {$inicio}, {$cantMostrar}";
            }
            else
            {
                $limit = "LIMIT {$cantMostrar}";
            }   
        }

        /**
         * Order by
         */
        if(isset($par['ordenar_por']))
        {
            $key = $par['ordenar_por'];
            $type = (isset($par['ordenar_tipo'])) ? $par['ordenar_tipo'] : 'ASC';
            if($type != "ASC" && $type != "DESC") $type = "ASC";
            $order_by = "ORDER BY {$key} {$type}";
        }

        /**
         * Consulta
         */
        $query = "SELECT * FROM roles {$where} {$order_by} {$limit}";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
    public static function Total($condicional = "")
    {
        $where = ( $condicional != "" ) ? "WHERE {$condicional}" : '';

        $query = "SELECT COUNT(*) AS cantidad FROM roles {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
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
	public static function ExisteNombre($nombre)
	{
		$nombre = Filtro::General($nombre);

		$query = "SELECT COUNT(*) AS cantidad FROM roles WHERE nombre = '{$nombre}'";
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
	public static function Registrar($nombre, $descripcion, $responsable = 0)
	{
		$idRol = Conexion::getMysql()->nextID("roles", "idRol");
		$nombre = Filtro::General($nombre);
		$descripcion = Filtro::General($descripcion);
		$responsable = boolval( $responsable );
		$fecha_registro = Time::get();

		$query = "INSERT INTO roles (idRol, nombre, descripcion, responsable, fecha_registro) VALUES ('{$idRol}', '{$nombre}', '{$descripcion}', '{$responsable}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un problema al intentar agregar el nuevo rol.");
		}

		$objRol = new RolModel($idRol);
		return $objRol;
	}

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Permiso($idRol, $idRestaurant)
    {
        $idRol = (int) $idRol;
        $idRestaurant = (int) $idRestaurant;

		$query = "SELECT COUNT(*) AS cantidad FROM roles_permisos WHERE idRol = '{$idRol}' AND idRestaurant = '{$idRestaurant}'";
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
    public static function setPermiso($idRol, $idRestaurant, $status)
    {
        $idRol = (int) $idRol;
        $idRestaurant = (int) $idRestaurant;
        $status = boolval($status);

        if($status) {
            $query = "INSERT INTO roles_permisos (idRol, idRestaurant) VALUES ('{$idRol}', '{$idRestaurant}')";
        } else {
            $query = "DELETE FROM roles_permisos WHERE idRol = '{$idRol}' AND idRestaurant = '{$idRestaurant}'";
        }

        Conexion::getMysql()->Ejecutar($query);
    }

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function ListadoRestaurant($idRestaurant)
    {
        $idRestaurant = (int) $idRestaurant;

        $query = "SELECT * FROM roles A, roles_permisos B WHERE A.idRol = B.idRol AND B.idRestaurant = '{$idRestaurant}'";
        $datos = Conexion::getMysql()->Consultar($query);

        return $datos;
    }
}