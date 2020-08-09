<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de MENU_A
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MenusAModel
{
	/*============================================================================
	 *
	 *	Listado
	 *
    ============================================================================*/
    public static function Listado($idRol = -1)
    {
        $idRol = (int) $idRol;

        if($idRol == -1) {
            $query = "SELECT * FROM menus_a ORDER BY idMenuA ASC";
        } else {
            $query = "SELECT * FROM menus_a WHERE idMenuA IN (SELECT idMenuA FROM permisos_a WHERE idRol = '{$idRol}') ORDER BY idMenuA ASC";
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
    
	/*============================================================================
	 *
	 *	Verificar
	 *
    ============================================================================*/
    public static function Verificar($idMenuA, $idRol)
    {
        $idMenuA = (int) $idMenuA;
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) as cantidad FROM permisos_a WHERE idMenuA = '{$idMenuA}' AND idRol = '{$idRol}'";
        $datos = Conexion::idRol()->Consultar($query);

        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }
}