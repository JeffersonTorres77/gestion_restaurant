<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de MENU_B
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MenusBModel
{
	/*============================================================================
	 *
	 *	Listado
	 *
    ============================================================================*/
    public static function Listado($idMenuA, $idRol = -1)
    {
        $idMenuA = (int) $idMenuA;
        $idRol = (int) $idRol;

        if($idRol == -1) {
            $query = "SELECT * FROM menus_b WHERE idMenuA = '{$idMenuA}' ORDER BY idMenuB ASC";
        } else {
            $query = "SELECT * FROM menus_b WHERE idMenuA = '{$idMenuA}' AND idMenuB IN (SELECT idMenuB FROM permisos_b WHERE idRol = '{$idRol}') ORDER BY idMenuB ASC";
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
    
	/*============================================================================
	 *
	 *	Verificar
	 *
    ============================================================================*/
    public static function Verificar($idMenuB, $idRol)
    {
        $idMenuB = (int) $idMenuB;
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) as cantidad FROM permisos_b WHERE idMenuB = '{$idMenuB}' AND idRol = '{$idRol}'";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }
}