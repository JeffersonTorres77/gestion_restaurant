<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de PLATOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PlatosModel
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
	public static function Listado($condicional = "", $par = [])
	{
		/**
         * Iniciar
         */
        $order_by = "";
        $where = "WHERE A.idCategoria = B.idCategoria";
        $limit = "";

        /**
         * Where
         */        
        if($condicional != "")
        {
            $where .= " AND ({$condicional})";
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
        $query = "SELECT * FROM platos A, categorias B {$where} {$order_by} {$limit}";
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
        $where = "WHERE A.idCategoria = B.idCategoria";
        $where .= ( $condicional != "" ) ? " AND ({$condicional})" : '';

        $query = "SELECT COUNT(*) AS cantidad FROM platos A, categorias B {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function ListadoCliente( $idRestaurant, $idCategoria = FALSE )
	{
		$idRestaurant = (int) $idRestaurant;
		$where = "WHERE idRestaurant = '{$idRestaurant}' AND activo = '1'";
		
		if($idCategoria !== FALSE)
		{
			if($where != "") $where .= " AND ";
			$where .= "idCategoria = '{$idCategoria}'";
		}

		$query = "SELECT * FROM platos {$where} ORDER BY nombre";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
	
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $nombre, $descripcion, $idCategoria, $precioCosto, $precioVenta, $activo)
	{
		//Busca el ID maximo e incrementa en 1
		$idPlato = Conexion::getMysql()->NextID("platos", "idPlato");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);
		$descripcion = Filtro::General($descripcion);
		$idCategoria = (int) $idCategoria;
		$precioCosto = $precioCosto;
		$precioVenta = $precioVenta;
		$activo = (int) $activo;
		$fecha_registro = Time::get();
		
		$query = "INSERT  INTO platos (idPlato, idRestaurant, idCategoria, nombre, descripcion, activo, precioCosto, precioVenta, fecha_registro)
			VALUES
			('{$idPlato}', '{$idRestaurant}', '{$idCategoria}', '{$nombre}', '{$descripcion}', '{$activo}', '{$precioCosto}', '{$precioVenta}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el Plato.");
		}

		$objPlato = new PlatoModel($idPlato);
		return $objPlato;
	}
}