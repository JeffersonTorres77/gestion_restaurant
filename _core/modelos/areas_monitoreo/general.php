<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de AREA DE MONITOREO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class AreasMonitoreoModel
{
	public static function General($condicional, $order = "")
    {
        $order = ($order == 'ASC' || $order == 'DESC') ? $order : 'ASC';

        if($condicional == "") $condicional = "'1' = '1'";
        $query = "SELECT * FROM areas_monitoreo WHERE {$condicional} ORDER BY nombre {$order}";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
	}
	
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Listado()
	{
        $query = "SELECT * FROM areas_monitoreo ORDER BY idAreaMonitoreo ASC";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}