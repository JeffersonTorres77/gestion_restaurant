<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Filtro
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Filtro
{
	/*============================================================================
	 *
	 *	Atributos
	 *
	============================================================================*/
    private static $numeros = "0123456789";
    private static $letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    private static $simbolos = ".:,;-_@#¿?¡!()/";

	/*============================================================================
	 *
	 *	General
	 *
	============================================================================*/
    public static function General($valor)
    {
        $general = self::$numeros.self::$letras.self::$simbolos;
        $salida = self::Accionar($general, $valor);
        return $salida;
    }

	/*============================================================================
	 *
	 *	Numeros
	 *
	============================================================================*/
    public static function Numeros($valor)
    {
        $salida = self::Accionar(self::$numeros, $valor);
        return $salida;
    }

	/*============================================================================
	 *
	 *	Letras
	 *
	============================================================================*/
    public static function Letras($valor)
    {
        $salida = self::Accionar(self::$letras, $valor);
        return $salida;
    }

	/*============================================================================
	 *
	 *	Accionar
	 *
	============================================================================*/
    private static function Accionar($caracteresValidos, $palabraFiltrar)
    {
        $palabraFiltrar = strval($palabraFiltrar);
        $salida = "";

        for($I=0; $I<strlen($palabraFiltrar); $I++)
        {
            if(strpos($caracteresValidos, $palabraFiltrar[$I]) !== FALSE)
            {
                $salida .= $palabraFiltrar[$I];
            }
        }

        return $salida;
    }
}