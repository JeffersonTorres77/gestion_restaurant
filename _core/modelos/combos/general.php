<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo GENERAL de COMBOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class CombosModel
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
        $query = "SELECT * FROM combos {$where} {$order_by} {$limit}";
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

        $query = "SELECT COUNT(*) AS cantidad FROM combos {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function ListadoCliente( $idRestaurant )
	{
		$idRestaurant = (int) $idRestaurant;
		$query = "SELECT * FROM combos WHERE idRestaurant = '{$idRestaurant}' AND activo = '1' ORDER BY nombre";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
	
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $nombre, $descripcion, $descuento)
	{
		//Busca el ID maximo e incrementa en 1
		$idCombo = Conexion::getMysql()->NextID("combos", "idCombo");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General(strtoupper($nombre));
		$descripcion = Filtro::General($descripcion);
		$descuento = Filtro::General($descuento);
		$activo = (int) TRUE;
		$fecha_registro = Time::get();
		
		$query = "INSERT INTO combos (idCombo, idRestaurant, nombre, descripcion, descuento, activo, fecha_registro)
			VALUES
			('{$idCombo}', '{$idRestaurant}', '{$nombre}', '{$descripcion}', '{$descuento}', '{$activo}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el combo.");
		}

		$objCombo = new ComboModel($idCombo);
		return $objCombo;
	}
}