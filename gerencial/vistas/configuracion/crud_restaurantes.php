<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE RESTAURANTES
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$accion = Input::POST("accion");
$objRestaurant = Sesion::getRestaurant();
$idRestaurant = $objRestaurant->getId();

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    /**
     * MODIFICAR
     */
    case "MODIFICAR":
        $documento = Input::POST("documento", FALSE);
        $nombre = Input::POST("nombre", FALSE);
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);
        $idMoneda = Input::POST("idMoneda", FALSE);

        /**
         * Imagen
         */
        if($_FILES && isset($_FILES['img']) && $_FILES['img']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $img = $_FILES['img'];
            $carpetaImg = DIR_IMG_REST."/".$objRestaurant->getId();
            $nombreImg = "logo";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objRestaurant->setLogo( "{$nombreImg}.{$extensionImg}" );
        }

        /**
         * Basico
         */
        if($documento !== FALSE) {
            if($documento == "") throw new Exception("El documento no puede estar vacio.");
            $objRestaurant->setDocumento( $documento );
        }

        if($nombre !== FALSE) {
            if($nombre == "") throw new Exception("El nombre no puede estar vacio.");
            $objRestaurant->setNombre( $nombre );
        }

        if($direccion !== FALSE) $objRestaurant->setDireccion( $direccion );
        if($telefono !== FALSE) $objRestaurant->setTelefono( $telefono );
        if($correo !== FALSE) $objRestaurant->setCorreo( $correo );
        if($idMoneda !== FALSE)
        {
            $objMoneda = new MonedaModel($idMoneda);
            $objRestaurant->setIdMoneda($objMoneda->getId());
        }

        /**
         * Redes
         */
        $whatsapp = Input::POST("whatsapp", FALSE);
        $facebook = Input::POST("facebook", FALSE);
        $twitter = Input::POST("twitter", FALSE);
        $instagram = Input::POST("instagram", FALSE);
        
        if($whatsapp !== FALSE) $objRestaurant->setWhatsapp( $whatsapp );
        if($facebook !== FALSE) $objRestaurant->setFacebook( $facebook );
        if($twitter !== FALSE) $objRestaurant->setTwitter( $twitter );
        if($instagram !== FALSE) $objRestaurant->setInstagram( $instagram );

        /**
         * Otros
         */

        $titulocomanda = Input::POST("titulocomanda", FALSE);
        $textocomanda = Input::POST("textocomanda", FALSE);
        $titulocombo = Input::POST("titulocombo", FALSE);
        $textocombo = Input::POST("textocombo", FALSE);

        if($titulocomanda !== FALSE) $objRestaurant->settitulocomanda( $titulocomanda );
        if($textocomanda !== FALSE) $objRestaurant->settextocomanda( $textocomanda );
        if($titulocombo !== FALSE) $objRestaurant->settitulocombo( $titulocombo );
        if($textocombo !== FALSE) $objRestaurant->settextocombo( $textocombo );

        /**
         * Imagen comanda
         */
        if($_FILES && isset($_FILES['imgComanda']) && $_FILES['imgComanda']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $imgcomanda = $_FILES['imgComanda'];
            $carpetaImg = DIR_IMG_REST."/".$objRestaurant->getId();
            $nombreImg = "imgcomanda";
            $aux = explode(".", $imgcomanda['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $imgcomanda);

            /**
             * Guardamos en la base de datos
             */
            $objRestaurant->setimagencomanda( "{$nombreImg}.{$extensionImg}" );
        }

        /**
         * Imagen Combos
         */
        if($_FILES && isset($_FILES['imgCombo']) && $_FILES['imgCombo']['name'] != "")
        {
            /**
             * Extraemos la data
             */
            $imgcombo = $_FILES['imgCombo'];
            $carpetaImg = DIR_IMG_REST."/".$objRestaurant->getId();
            $nombreImg = "imgcombo";
            $aux = explode(".", $imgcombo['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $imgcombo);

            /**
             * Guardamos en la base de datos
             */
            $objRestaurant->setimagencombo( "{$nombreImg}.{$extensionImg}" );
        }
        
        Conexion::getMysql()->Commit();        

        $respuesta['cuerpo'] = [
            "id" => $objRestaurant->getId(),
            "documento" => $objRestaurant->getDocumento(),
            "nombre" => $objRestaurant->getNombre(),
            "direccion" => $objRestaurant->getDireccion(),
            "telefono" => $objRestaurant->getTelefono(),
            "correo" => $objRestaurant->getCorreo(),
            "whatsapp" => $objRestaurant->getWhatsapp(),
            "twitter" => $objRestaurant->getTwitter(),
            "instagram" => $objRestaurant->getInstagram(),
            "facebook" => $objRestaurant->getFacebook(),
            "activo" => $objRestaurant->getActivo()
        ];
    break;

    /**
     * OTROS
     */
    default:
        throw new Exception("Acción invalida.");
    break;
}