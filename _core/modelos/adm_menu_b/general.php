<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de ADMIN_MENU_B
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class AdminMenusBModel
{
	/*============================================================================
	 *
	 *	Listado
	 *
    ============================================================================*/
    public static function Listado($idMenuA)
    {
        $idMenuA = (int) $idMenuA;

        $query = "SELECT * FROM adm_menus_b WHERE idMenuA = '{$idMenuA}' ORDER BY nombre ASC";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
}