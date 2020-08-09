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

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    case "REGISTRAR":
        /**
         * Tomamos los datos del resturant
         */
        $documento_restaurant = Input::POST("documento-restaurant");
        $nombre_restaurant = Input::POST("nombre-restaurant");
        $direccion_restaurant = Input::POST("direccion-restaurant");
        $telefono_restaurant = Input::POST("telefono-restaurant");
        $correo_restaurant = Input::POST("correo-restaurant");

        /**
         * Tomamos los datos del gerente
         */
        $documento_gerente = Input::POST("documento-gerente");
        $nombre_gerente = Input::POST("nombre-gerente");
        $direccion_gerente = Input::POST("direccion-gerente");
        $telefono_gerente = Input::POST("telefono-gerente");
        $correo_gerente = Input::POST("correo-gerente");
        $usuario_gerente = Input::POST("usuario-gerente");
        $clave_gerente = Input::POST("clave-gerente");
        $clave2_gerente = Input::POST("clave2-gerente");

        /**
         * Validamos los datos
         */
        if( RestaurantesModel::Existe($documento_restaurant, $nombre_restaurant) ) {
            throw new Exception("Ya se encuentra un restaurant con los siguientes datos:<br>Documento: {$documento_restaurant}<br>Nombre: {$nombre_restaurant}");
        }

        if($clave_gerente != $clave2_gerente) {
            throw new Exception("Las contraseñas tienen que ser iguales.");
        }
        
        /**
         * Registramos al restaurant
         */
        $objRestaurant = RestaurantesModel::Registrar(
            $documento_restaurant,
            $nombre_restaurant,
            $direccion_restaurant,
            $telefono_restaurant,
            $correo_restaurant
        );

        if( UsuariosModel::Existe($objRestaurant->getId(), $usuario_gerente) ) {
            throw new Exception("Ya se encuentra registrado el usuario <b>{$usuario_gerente}</b>.");
        }

        /**
         * Registramos los roles
         */
        $objRolGerente = RolesModel::Registrar( $objRestaurant->getId(), "GERENTE", "", TRUE);
        $objRolBasico = RolesModel::Registrar( $objRestaurant->getId(), "BASICO", "");

        /**
         * Registramos los permisos
         */

        //GERENTE
        $objRolGerente->setPermisosA(1, TRUE);
        $objRolGerente->setPermisosA(2, TRUE);
        $objRolGerente->setPermisosA(3, TRUE);
        $objRolGerente->setPermisosA(4, TRUE);
        $objRolGerente->setPermisosA(5, TRUE);
        $objRolGerente->setPermisosA(6, TRUE);
        $objRolGerente->setPermisosA(7, TRUE);
        $objRolGerente->setPermisosA(8, TRUE);

        $objRolGerente->setPermisosB(1, TRUE);
        $objRolGerente->setPermisosB(2, TRUE);
        $objRolGerente->setPermisosB(3, TRUE);
        $objRolGerente->setPermisosB(4, TRUE);
        $objRolGerente->setPermisosB(5, TRUE);
        $objRolGerente->setPermisosB(6, TRUE);
        $objRolGerente->setPermisosB(7, TRUE);

        //BASICO
        $objRolBasico->setPermisosA(2, TRUE);
        $objRolBasico->setPermisosA(3, TRUE);
        $objRolBasico->setPermisosA(4, TRUE);
        $objRolBasico->setPermisosA(7, TRUE);
        $objRolBasico->setPermisosA(8, TRUE);

        /**
         * Registramos el gerente
         */
        $objUsuario = UsuariosModel::Registrar(
            $usuario_gerente,
            $objRestaurant->getId(),
            $clave_gerente,
            $documento_gerente,
            $nombre_gerente,
            $objRolGerente->getId(),
            $direccion_gerente,
            $telefono_gerente,
            $correo_gerente
        );

        /**
         * Guardamos los cambios
         */
        Conexion::getMysql()->Commit();

        /**
         * Creamos la carpeta
         */
        $ruta = DIR_IMG_REST."/".$objRestaurant->getId();
        if( !(file_exists( $ruta ) && is_dir( $ruta )) ) {
            mkdir( $ruta );
        }

        /**
         * Retornamos los datos imporantes
         */
        $respuesta['cuerpo'] = [
            "id" => $objRestaurant->getId()
        ];
    break;

    case "CONSULTAR":
        /**
         * Tomamos los parametros
         */
        $order_key = Input::POST("order_key", FALSE);
        $order_type = Input::POST("order_type", FALSE);
        $pagina = (int) Input::POST("pagina", FALSE);
        $cantMostrar = (int) Input::POST("cantMostrar", FALSE);
        $buscar = Filtro::General( Input::POST("buscar", FALSE) );

        /**
         * Valores por defecto
         */
        if($order_key === FALSE) $order_key = 'nombre';
        if($order_type === FALSE) $order_type = 'ASC';
        if($pagina === FALSE) $pagina = 1;
        if($cantMostrar === 0) $cantMostrar = 10;

        /**
         * Con busqueda
         */
        if($buscar != FALSE)
        {
            $condicional = "nombre LIKE '%{$buscar}%' OR ";
            $condicional .= "documento LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $restaurantes = RestaurantesModel::Listado( $condicional, $par );
            $total_filas = RestaurantesModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $restaurantes = RestaurantesModel::Listado( '', $par );
            $total_filas = RestaurantesModel::Total();
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($restaurantes); $I++)
        {
            $objRestaurant = new RestaurantModel( $restaurantes[$I]['idRestaurant'] );
            $datos[$I] = [
                "id" => $objRestaurant->getId(),
                "logo" => $objRestaurant->getLogo(),
                "nombre" => $objRestaurant->getNombre(),
                "documento" => $objRestaurant->getDocumento(),
                "activo" => boolval( $objRestaurant->getActivo() ),
                "fecha_registro" => $objRestaurant->getFechaRegistro()
            ];
        }

        /**
         * Retornamos la respuesta
         */
        $respuesta['cuerpo'] = [
            "order_key" => $order_key,
            "order_type" => $order_type,
            "pagina" => $pagina,
            "cantMostrar" => $cantMostrar,
            "total_filas" => $total_filas,
            "data" => $datos
        ];
    break;

    case "MODIFICAR":
        $idRestaurant = Input::POST("idRestaurant");
        $objRestaurant = new RestaurantModel($idRestaurant);

        $documento = Input::POST("documento", FALSE);
        $nombre = Input::POST("nombre", FALSE);
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);
        $activo = Input::POST("activo", FALSE);

        /**
         * Imagen
         */
        if($_FILES && $_FILES['img'] && $_FILES['img']['name'] != "")
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
         * Otros datos
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
        if($activo !== FALSE) $objRestaurant->setActivo( $activo );

        $whatsapp = Input::POST("whatsapp", FALSE);
        $facebook = Input::POST("facebook", FALSE);
        $twitter = Input::POST("twitter", FALSE);
        $instagram = Input::POST("instagram", FALSE);
        
        if($whatsapp !== FALSE) $objRestaurant->setWhatsapp( $whatsapp );
        if($facebook !== FALSE) $objRestaurant->setFacebook( $facebook );
        if($twitter !== FALSE) $objRestaurant->setTwitter( $twitter );
        if($instagram !== FALSE) $objRestaurant->setInstagram( $instagram );
        
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

    case "ELIMINAR":
        /**
         * Tomamos los parametros esperados
         */
        $idRestaurant = Input::POST("idRestaurant");

        /**
         * Verificamos los parametros
         */
        $objRestaurant = new RestaurantModel($idRestaurant);

        /**
         * Ejecutamos la operación dependiendo del estado actual
         */
        if($objRestaurant->getActivo()) {
            $objRestaurant->setActivo(FALSE);
        } else {
            $objRestaurant->setActivo(TRUE);
        }

        /**
         * Guardamos los cambios ejecutados
         */
        Conexion::getMysql()->Commit();

        /**
         * Preparamos la data a retornar
         */
        $respuesta['cuerpo'] = [
            "id" => $objRestaurant->getId(),
            "nombre" => $objRestaurant->getNombre(),
            "activo" => $objRestaurant->getActivo()
        ];
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}