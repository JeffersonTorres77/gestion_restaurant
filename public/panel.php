<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Incluimos los archivos necesarios
 *
 *--------------------------------------------------------------------------------
================================================================================*/
IncluirCarpeta(BASE_DIR."_core/utils");
IncluirCarpeta(BASE_DIR."_core/modelos");
require_once(BASE_DIR."_core/APIs/database/mysql.php");
require_once(BASE_DIR."_core/APIs/database/sqlite3.php");

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Iniciamos clases escenciales
 *
 *--------------------------------------------------------------------------------
================================================================================*/
Sesion::Iniciar();
Conexion::Iniciar();

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Verificamos el controlador y el metodo
 *
 *--------------------------------------------------------------------------------
================================================================================*/
$controlador = Peticion::getControlador();
if($controlador == "index" || $controlador == "inicio" || $controlador == "") $controlador = "principal";
$archivo = BASE_DIR . "public/controladores/{$controlador}.php";
$controlador = "Controlador";
$metodo = Peticion::getMetodo();

require_once(BASE_DIR . "public/controladores/_base.php");
VerificarPagina($archivo, $controlador, $metodo);

/*================================================================================
 * Creamos el controlador y llamamos al metodo
================================================================================*/
$controlador = new Controlador();
$controlador->$metodo( Peticion::getParametros() );