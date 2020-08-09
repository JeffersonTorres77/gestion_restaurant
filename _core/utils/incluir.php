<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Incluir
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Incluir
{
    /*============================================================================
	 *
	 *	Template
	 *
    ============================================================================*/
    public static function Template($nombre)
    {
        $ruta = BASE_DIR . "_core/templates/{$nombre}/template.php";
        if( !(file_exists($ruta) && is_file($ruta)) )
        {
            throw new Exception("Template <b>{$nombre}</b> no existe.");
        }

        require_once($ruta);
    }

    /*============================================================================
	 *
	 *	Vista
	 *
    ============================================================================*/
    public static function Vista($nombre, $parametros = [])
    {
        $ruta = BASE_DIR . "core/vistas/{$nombre}.php";
        if( !(file_exists($ruta) && is_file($ruta)) )
        {
            throw new Exception("Vista <b>{$nombre}</b> no existe.");
        }

        foreach($parametros as $key => $value)
        {
            $$key = $value;
        }

        require_once($ruta);
    }

    /*============================================================================
	 *
	 *	AJAX
	 *
    ============================================================================*/
    public static function AJAX($nombre)
    {
        $ruta = BASE_DIR . "core/vistas/{$nombre}.php";
        if( !(file_exists($ruta) && is_file($ruta)) )
        {
            throw new Exception("Vista <b>{$nombre}</b> no existe.");
        }

        if(!Peticion::getEsAjax())
        {
            throw new Exception("Es necesario enviar una solicitud AJAX para acceder a esta sección.");
        }

        $respuesta = [];
        $respuesta['status'] = TRUE;
        $respuesta['mensaje'] = "...";
        $respuesta['data'] = [];

        require_once($ruta);
    }
}