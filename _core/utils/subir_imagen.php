<?php

/**
 * Parametros
 * 
 * Carpeta: Carpeta donde se guardara la imagen.
 * Nombre: Nombre del archivo (sin extension) con el que se guardara.
 * Imagen: Objeto $_FILES[<imagen>] a subir
 */
function SubirImagen($carpeta, $nombre, $imagen)
{
    /**
     * Extraemos los datos
     */
    $arrayAux = explode(".", $imagen['name']);
    $extension = $arrayAux[ sizeof($arrayAux) - 1 ];
    $archivo = "{$carpeta}/{$nombre}.{$extension}";

    /**
     * Creamos la carpeta si no existe
     */
    if( !(file_exists($carpeta) && is_dir( $carpeta )) ) {
        mkdir( $carpeta );
    }

    /**
     * Validamos la imagen
     */
    $array_extensiones = [ "JPG", "PNG", "TIF", "BMP", "PSD", "GIF", "RAW", "AI", "EPS", "SVG", "PDF", "CDR" ];
    $existe = FALSE;
    foreach($array_extensiones as $extension_actual)
    {
        if(strtoupper($extension) == strtoupper($extension_actual)) {
            $existe = TRUE;
            break;
        }
    }
    if($existe === FALSE) {
        throw new Exception("Formato <b>{$extension}</b> invalido.");
    }

    /**
     * Eliminamos las imagenes ya existentes en la carpeta con el mismo nombre (sin contar extensiones)
     */
    $path = pathinfo( $archivo );
    $archivos_carpeta = scandir( $carpeta );
    foreach($archivos_carpeta as $img)
    {
        if($img == "." || $img == "..") continue;
        $archivo_actual = "{$carpeta}/$img";
        $path_actual = pathinfo( $archivo_actual );
        if($path_actual['filename'] == $path['filename']) {
            unlink( $archivo_actual );
        }
    }

    /**
     * Movemos el archivo a la carpeta de destino con el nombre enviado
     */
    if(!move_uploaded_file($imagen['tmp_name'], $archivo)) {
        throw new Exception("Ocurrio un error al intentar mover el archivo al servidor.");
    }
}