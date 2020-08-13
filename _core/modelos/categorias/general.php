<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo GENERAL de CATEGORIAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class CategoriasModel
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
        $query = "SELECT * FROM categorias {$where} {$order_by} {$limit}";
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

        $query = "SELECT COUNT(*) AS cantidad FROM categorias {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($nombre, $idAreaMonitoreo, $idRestaurant)
	{
		$idCategoria = Conexion::getMysql()->NextID("categorias", "idCategoria");
		$idRestaurant = (int) $idRestaurant;
		$nombre = Filtro::General($nombre);
		$idAreaMonitoreo = (int) $idAreaMonitoreo;
		$fecha_registro = Time::get();

		$query = "INSERT INTO categorias (idCategoria, idRestaurant, nombre, idAreaMonitoreo, fecha_registro) VALUES ('{$idCategoria}', '{$idRestaurant}', '{$nombre}', '{$idAreaMonitoreo}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar la categoria.");
		}

		$objCategoria = new CategoriaModel($idCategoria);
		return $objCategoria;
	}
}