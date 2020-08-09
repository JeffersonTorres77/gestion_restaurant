<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Manejadores de errores
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 *
 *	Vistas
 *
================================================================================*/

/*--------------------------------------------------------------------------------
 * Exception
--------------------------------------------------------------------------------*/
function Gestor_Exceptiones($exception)
{
    $codigo = $exception->getCode();
    $mensaje = $exception->getMessage();
    $archivo = $exception->getFile();
    $linea = $exception->getLine();
    $trazas = $exception->getTrace();

    if(AUDITORIA)
    {
        require_once(BASE_DIR."_core/vistas/exception-sistema.php");
    }
    else
    {
        require_once(BASE_DIR."_core/vistas/error-generico.php");
    }
    
    exit;
}

/*--------------------------------------------------------------------------------
 * Error
--------------------------------------------------------------------------------*/
function Gestor_Errores($codigo, $mensaje, $archivo = "", $linea = "", $context = "")
{
    if(AUDITORIA)
    {
        require_once(BASE_DIR."_core/vistas/error-sistema.php");
    }
    else
    {
        require_once(BASE_DIR."_core/vistas/error-generico.php");
    }
    
    exit;
}

/*================================================================================
 *
 *	AJAX
 *
================================================================================*/

/*--------------------------------------------------------------------------------
 * Exception
--------------------------------------------------------------------------------*/
function Gestor_Exceptiones_AJAX($exception)
{
    $codigo = $exception->getCode();
    $mensaje = $exception->getMessage();
    $archivo = $exception->getFile();
    $linea = $exception->getLine();
    $trazas = $exception->getTrace();

    $respuesta = [
        "error" => [],
        "cuerpo" => []
    ];

    $respuesta['error']['status'] = TRUE;
    $respuesta['error']['mensaje'] = $mensaje;

    $respuesta['cuerpo'] = [
        "codigo" => $codigo,
        "mensaje" => $mensaje,
        "archivo" => $archivo,
        "linea" => $linea,
        "trazas" => $trazas
    ];

    echo json_encode( $respuesta );
    exit;
}

/*--------------------------------------------------------------------------------
 * Error
--------------------------------------------------------------------------------*/
function Gestor_Errores_AJAX($codigo, $mensaje, $archivo = "", $linea = "", $context = "")
{
    $respuesta = [
        "error" => [],
        "cuerpo" => []
    ];

    $respuesta['error']['status'] = TRUE;
    $respuesta['error']['mensaje'] = $mensaje;
    
    $respuesta['cuerpo'] = [
        "codigo" => $codigo,
        "mensaje" => $mensaje,
        "archivo" => $archivo,
        "linea" => $linea,
        "trazas" => []
    ];

    echo json_encode( $respuesta );
    exit;
}