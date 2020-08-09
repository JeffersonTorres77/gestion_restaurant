<?php
/*================================================================================
 *
 * Incluimos los archivos necesarios
 *
================================================================================*/
require_once(__DIR__."/_core/constantes.php");
require_once(__DIR__."/_core/funciones.php");
require_once(__DIR__."/_core/handlers.php");
require_once(__DIR__."/_core/peticion.php");

define("HOST_ACTUAL", $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

/*================================================================================
 *
 * Analizamos la URL
 *
================================================================================*/
Peticion::Analizar();

/*================================================================================
 *
 * Iniciamos los handlers dependiendo de la petición recibida
 *
================================================================================*/
if(Peticion::getEsAjax()) {
    set_exception_handler("Gestor_Exceptiones_AJAX");
    set_error_handler("Gestor_Errores_AJAX");
} else {
    set_exception_handler("Gestor_Exceptiones");
    set_error_handler("Gestor_Errores");
}

/*================================================================================
 *
 *	
 *
================================================================================*/
require_once(__DIR__."/".Peticion::getArea()."/panel.php");

?>