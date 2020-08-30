<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de MESAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MesasModel
{
    public static function General($condicional, $order = "")
    {
        $order = ($order == 'ASC' || $order == 'DESC') ? $order : 'ASC';

        if($condicional == "") $condicional = "'1' = '1'";
        $query = "SELECT * FROM mesas WHERE {$condicional} ORDER BY alias {$order}";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

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
	public static function Listado($condicional = "", $par = [])
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
        $query = "SELECT * FROM mesas {$where} {$order_by} {$limit}";
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

        $query = "SELECT COUNT(*) AS cantidad FROM mesas {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $alias, $usuario, $clave)
	{
		$idMesa = Conexion::getMysql()->NextID("mesas", "idMesa");
		$idRestaurant = (int) $idRestaurant;
		$status = "ABIERTA";
		$alias = Filtro::General($alias);
		$usuario = Filtro::General($usuario);
		$clave = Filtro::General($clave);
		$aux_1 = "";
		$aux_2 = "";
		$aux_3 = "";
		$fecha_registro = Time::get();

		$query = "INSERT INTO mesas (idMesa, idRestaurant, status, alias, usuario, clave, aux_1, aux_2, aux_3, fecha_registro) VALUES ('{$idMesa}', '{$idRestaurant}', '{$status}', '{$alias}', '{$usuario}', '{$clave}', '{$aux_1}', '{$aux_2}', '{$aux_3}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar la Mesa.");
		}

		$objMesa = new MesaModel($idMesa);
		return $objMesa;
	}

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function BuscarPorUsuario($idRestaurant, $usuario)
	{
		$idRestaurant = (int) $idRestaurant;
		$usuario = Filtro::General($usuario);

		$query = "SELECT * FROM mesas WHERE usuario = '{$usuario}'";
		$datos = Conexion::getMysql()->Consultar($query);
		if(sizeof($datos) == 0) {
			throw new Exception("Usuario de mesa <b>{$usuario}</b> no encontrado.");
		}

		$objMesa = new MesaModel($datos[0]['idMesa']);
		return $objMesa;
	}

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Existe($idRestaurant, $usuario)
	{
		$idRestaurant = (int) $idRestaurant;
		$usuario = Filtro::General($usuario);

		$query = "SELECT COUNT(*) AS cantidad FROM mesas WHERE usuario = '{$usuario}'";
		$datos = Conexion::getMysql()->Consultar($query);
		$cantidad = $datos[0]['cantidad'];

		if($cantidad > 0) return TRUE;
		else return FALSE;
	}
}