<?php
/*================================================================================
 *
 *	Incluir los elementos de una carpeta
 *
================================================================================*/
function IncluirCarpeta($ruta)
{
    if($ruta[ strlen($ruta) - 1 ] != "/") $ruta .= "/";
    
	$directorio = opendir($ruta);
	while($archivo = readdir($directorio))
	{
		if($archivo == '.' || $archivo == '..')
			continue;

		if(is_dir($ruta.$archivo))
		{
			IncluirCarpeta($ruta.$archivo."/");
			continue;
		}

		require_once($ruta.$archivo);
	}
}

/*================================================================================
 *
 *	Verificamos la pagina
 *
================================================================================*/
function VerificarPagina($archivo, $controlador, $metodo)
{
	$peticion = Peticion::getPeticion();
	
	/*================================================================================
	 *	Verificamos el archivo e incluimos
	================================================================================*/
	if(!file_exists($archivo))
	{
		if(Peticion::getEsAjax()) {
			throw new Exception("Archivo '{$peticion}' no encontrado.");
		} else {
			require_once(BASE_DIR."_core/vistas/404.php");
			exit;
		}
	}

	require_once($archivo);

	/*================================================================================
	*	Verificamos el controlador
	================================================================================*/
	if(!class_exists( $controlador ))
	{
		if(Peticion::getEsAjax()) {
			throw new Exception("Controlador '{$peticion}' no encontrado.");
		} else {
			require_once(BASE_DIR."_core/vistas/404.php");
			exit;
		}
	}

	/*================================================================================
	*	Verificamos el metodo
	================================================================================*/
	if(!method_exists( $controlador, $metodo ))
	{
		if(Peticion::getEsAjax()) {
			throw new Exception("Metodo '{$peticion}' no encontrado.");
		} else {
			require_once(BASE_DIR."_core/vistas/404.php");
		}
		
		exit;
	}
}