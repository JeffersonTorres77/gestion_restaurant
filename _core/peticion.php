<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Peticion
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Peticion
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private static $peticion;
    private static $esAjax;
    private static $area;
    private static $controlador;
    private static $metodo;
    private static $parametros;
    
    /*============================================================================
	 *
	 *	Iniciar el analisis de la petición
	 *
    ============================================================================*/
    public static function Analizar()
    {
        //Guardamos la petición
        if(!isset($_GET['url'])) {
            self::$peticion = "";
        } else {
            self::$peticion = $_GET['url'];
        }

        //Valores por defecto
        self::$esAjax = FALSE;
        self::$area = "";
        self::$controlador = "";
        self::$metodo = "";
        self::$parametros = [];

        //Convertimos la peticion en un array
        $arrayPeticion = explode("/", trim( self::$peticion, "/" ));

        /* Analizamos el area donde se trabajara */
        if($arrayPeticion[0] == AREA_ADMIN)
        {
            self::$area = "administrador";
            unset($arrayPeticion[0]);
            array_values($arrayPeticion);
        }
        elseif($arrayPeticion[0] == AREA_GERENCIAL)
        {
            self::$area = "gerencial";
            unset($arrayPeticion[0]);
            array_values($arrayPeticion);
        }
        else
        {
            self::$area = "public";
        }

        foreach($arrayPeticion as $valor)
        {
            if($valor == PREFIJO_AJAX)
            {
                self::$esAjax = TRUE;
            }

            elseif(self::$controlador == "")
            {
                self::$controlador = strtolower($valor);
            }

            elseif(self::$metodo == "")
            {
                self::$metodo = strtolower($valor);
            }

            else
            {
                array_push(self::$parametros, $valor);
            }
        }

        //Verificamos los valores
        if(self::$controlador == "") self::$controlador = "inicio";
        if(self::$metodo == "") self::$metodo = "index";
    }
    
    /*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public static function getPeticion() {
        return self::$peticion;
    }
    
    public static function getEsAjax() {
        return self::$esAjax;
    }
    
    public static function getArea() {
        return self::$area;
    }
    
    public static function getControlador() {
        return self::$controlador;
    }
    
    public static function getMetodo() {
        return self::$metodo;
    }
    
    public static function getParametros() {
        return self::$parametros;
    }
}