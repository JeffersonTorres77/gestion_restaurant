<?php

/*============================================================================
 *
 * RUTA DE CERTIFICADOS
 * 
============================================================================*/
//define("PATH_CERTIFICADO", "/home/dinerofr/ssl/certs/restaurante_app_jonathancolina_com_cf89a_2c839_1602806399_59a346b9d893e033c3b82f8aed585424.crt");
//define("PATH_KEY", "/home/dinerofr/ssl/keys/a9303_2509b_9e2ce7f674303726fcd3d9b9fb06f5b7.key");
define("PATH_CERTIFICADO", "C:/xampp/apache/conf/ssl.crt/localhost.crt");
define("PATH_KEY", "C:/xampp/apache/conf/ssl.key/localhost.key");

/*============================================================================
 *
 * Directorios
 * 
============================================================================*/
define("BASE_DIR", str_replace( "\\", "/", dirname(__DIR__) . "/" ));

/*============================================================================
*
* Urls
* 
============================================================================*/
define("PREFIJO_AJAX", "_AJAX");

/*============================================================================
 *
 * Cliente
 * 
============================================================================*/
if(isset($_SERVER['REMOTE_ADDR']))
{
    if($_SERVER['REMOTE_ADDR'] == "::1") define("IP_CLIENTE", "127.0.0.1");
    else define("IP_CLIENTE", 			$_SERVER['REMOTE_ADDR']);
}

/*============================================================================
 *
 * Ruta archivo .ini
 * 
============================================================================*/
define("CONFIG_INI", BASE_DIR."config.ini");

/*============================================================================
 *
 * Meses
 * 
============================================================================*/
define("MESES", [
    "01" => ["nombre" => "Enero", 		"dias" => "31", "dias_bisiesto" => "31"],
    "02" => ["nombre" => "Febrero", 	"dias" => "28", "dias_bisiesto" => "29"],
    "03" => ["nombre" => "Marzo", 		"dias" => "31", "dias_bisiesto" => "31"],
    "04" => ["nombre" => "Abril", 		"dias" => "30", "dias_bisiesto" => "30"],
    "05" => ["nombre" => "Mayo", 		"dias" => "31", "dias_bisiesto" => "31"],
    "06" => ["nombre" => "Junio", 		"dias" => "30", "dias_bisiesto" => "30"],
    "07" => ["nombre" => "Julio", 		"dias" => "31", "dias_bisiesto" => "31"],
    "08" => ["nombre" => "Agosto", 		"dias" => "31", "dias_bisiesto" => "31"],
    "09" => ["nombre" => "Septiembre", 	"dias" => "30", "dias_bisiesto" => "30"],
    "10" => ["nombre" => "Octubre", 	"dias" => "31", "dias_bisiesto" => "31"],
    "11" => ["nombre" => "Noviembre", 	"dias" => "30", "dias_bisiesto" => "30"],
    "12" => ["nombre" => "Diciembre", 	"dias" => "31", "dias_bisiesto" => "31"]
]);

/*============================================================================
 *----------------------------------------------------------------------------
 *
 *	CONSTANTES DE LOS ARCHIVOS .INI
 *
 *----------------------------------------------------------------------------
============================================================================*/

/*============================================================================
*
* Abrimos INI
* 
============================================================================*/
try
{
	$config = parse_ini_file(CONFIG_INI, TRUE);
}
catch(Exception $e)
{
	throw new Exception("Ocurrio un problema al intentar leer el archivo 'config.ini'.");
}

/*============================================================================
*
* Validamos
* 
============================================================================*/
try
{
    if(!isset($config['BaseDatos']['servidor'])) throw new Exception("No existe el parametro <b>servidor</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['puerto'])) throw new Exception("No existe el parametro <b>puerto</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['usuario'])) throw new Exception("No existe el parametro <b>usuario</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['clave'])) throw new Exception("No existe el parametro <b>clave</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['nombre_bd'])) throw new Exception("No existe el parametro <b>nombre_bd</b> en <b>BaseDatos</b>.");
    
    if(!isset($config['WebSocket']['url'])) throw new Exception("No existe el parametro <b>url</b> en <b>WebSocket</b>.");
    
    if(!isset($config['Seguridad']['key'])) throw new Exception("No existe el parametro <b>key</b> en <b>Seguridad</b>.");
    if(!isset($config['Seguridad']['auditoria'])) throw new Exception("No existe el parametro <b>auditoria</b> en <b>Seguridad</b>.");
    
    if(!isset($config['Sistema']['nombre'])) throw new Exception("No existe el parametro <b>nombre</b> en <b>Sistema</b>.");
    if(!isset($config['Sistema']['version'])) throw new Exception("No existe el parametro <b>version</b> en <b>Sistema</b>.");
    if(!isset($config['Sistema']['fase'])) throw new Exception("No existe el parametro <b>fase</b> en <b>Sistema</b>.");

    if(!isset($config['Areas']['administrador'])) throw new Exception("No existe el parametro <b>administrador</b> en <b>Areas</b>.");
    if(!isset($config['Areas']['gerencial'])) throw new Exception("No existe el parametro <b>gerencial</b> en <b>Areas</b>.");
    if(!isset($config['Areas']['public'])) throw new Exception("No existe el parametro <b>public</b> en <b>Areas</b>.");
}
catch(Exception $e)
{
    throw new Exception("Ocurrio un problema al validar los archivos INI.:<br>{$e->getMessage()}");
}

/*============================================================================
*
* Generamos
* 
============================================================================*/
try
{
    define("BD_SERVIDOR", $config["BaseDatos"]['servidor']);
    define("BD_PUERTO", $config["BaseDatos"]['puerto']);
    define("BD_USUARIO", $config["BaseDatos"]['usuario']);
    define("BD_CLAVE", $config["BaseDatos"]['clave']);
    define("BD_NOMBRE", $config["BaseDatos"]['nombre_bd']);
    
    define("WEBSOCKET_URL", $config["WebSocket"]['url']);
    
    define("SEGURIDAD_KEY", $config["Seguridad"]['key']);
    define("SEGURIDAD_AUDITORIA", $config["Seguridad"]['auditoria']);
    define("AUDITORIA", ( SEGURIDAD_AUDITORIA == "1" ));
    
    define("SISTEMA_NOMBRE", $config["Sistema"]['nombre']);
    define("SISTEMA_VERSION", $config["Sistema"]['version']);
    define("SISTEMA_FASE", $config["Sistema"]['fase']);
    
    define("AREA_ADMIN", $config["Areas"]['administrador']);
    define("AREA_GERENCIAL", $config["Areas"]['gerencial']);
    define("AREA_PUBLIC", $config["Areas"]['public']);

    define("HOST", $config['Sistema']['url_base']);
    define("HOST_AJAX", HOST.PREFIJO_AJAX."/");

    define("HOST_ADMIN", HOST.AREA_ADMIN."/");
    define("HOST_ADMIN_AJAX", HOST_ADMIN.PREFIJO_AJAX."/");

    define("HOST_GERENCIAL", HOST.AREA_GERENCIAL."/");
    define("HOST_GERENCIAL_AJAX", HOST_GERENCIAL.PREFIJO_AJAX."/");
}
catch(Exception $e)
{
    throw new Exception("Ocurrio un problema al definir las constantes INI:<br>{$e->getMessage()}");
}

/*============================================================================
 *
 * ADICINAL 2020-06-11
 * 
============================================================================*/
define("DIR_IMG_REST", BASE_DIR."recursos/restaurantes");
define("HOST_IMG_REST", HOST."recursos/restaurantes");

define("STATUS_MESAS", [
    "ABIERTA" => "Abierta",
    "CERRADA" => "Cerrada"
]);

define("STATUS_PEDIDOS", [
    0 => "SIN CONFIRMAR",
    1 => "CONFIRMADO",
    2 => "COCINADO",
    3 => "DESPACHADO",
    4 => "PAGADO",
    5 => "CANCELADO"
]);

/*============================================================================
 *
 * ADICINAL 2020-06-30
 * 
============================================================================*/
define("IMG_PLATO_DEFECTO", "recursos/core/img/plato-defecto.png");
define("IMG_COMBO_DEFECTO", "recursos/core/img/combo-defecto.jpg");
define("IMG_LOGO_DEFECTO", "recursos/core/img/logo-defecto.png");
define("IMG_USUARIO_DEFECTO", "recursos/core/img/user-defecto.png");

define("RUTA_CARPETA_DB_TEMPORAL", BASE_DIR."database_temporary");