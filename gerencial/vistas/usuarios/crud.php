<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE USUARIOS
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
     * CONSULTAR
     */
    case "CONSULTAR":
        /**
         * Tomamos los parametros
         */
        $order_key = Input::POST("order_key", FALSE);
        $order_type = Input::POST("order_type", FALSE);
        $pagina = (int) Input::POST("pagina", FALSE);
        $cantMostrar = (int) Input::POST("cantMostrar", FALSE);
        $buscar = Filtro::General( Input::POST("buscar", FALSE) );
        $filtros = Input::POST("filtros", FALSE);

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
            $condicional .= "usuario LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $usuarios = UsuariosModel::Listado( $condicional, $par );
            $total_filas = UsuariosModel::Total( $condicional );
        }
        /**
         * Con filtros
         */
        elseif($filtros !== FALSE)
        {
            $usuario = Filtro::General( Input::POST("usuario", FALSE) );
            $nombre = Filtro::General( Input::POST("nombre", FALSE) );
            $activo = boolval( Input::POST("activo", FALSE) );

            $condicional = "";

            if($usuario !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "usuario LIKE '%{$usuario}%'";
            }

            if($nombre !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "nombre LIKE '%{$nombre}%'";
            }

            if($activo !== FALSE) {
                if($condicional != "") $condicional .= " AND ";
                $condicional .= "activo = '{$activo}'";
            }

            $condicional = "idRestaurant = '{$idRestaurant}' AND ({$condicional})";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $usuarios = UsuariosModel::Listado( $condicional, $par );
            $total_filas = UsuariosModel::Total( $condicional );
        }
        /**
         * Sin busqueda
         */
        else
        {
            $condicional = "idRestaurant = '{$idRestaurant}'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $usuarios = UsuariosModel::Listado( $condicional, $par );
            $total_filas = UsuariosModel::Total( $condicional );
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($usuarios); $I++)
        {
            $objUsuario = new UsuarioModel( $usuarios[$I]['idUsuario'] );
            $objRestaurant = new RestaurantModel( $objUsuario->getIdRestaurant() );
            $datos[$I] = [
                "id" => $objUsuario->getId(),
                "foto" => $objUsuario->getFoto(),
                "usuario" => $objUsuario->getUsuario(),
                "nombre" => $objUsuario->getNombre(),
                "rol" => [
                    "nombre" => $objUsuario->getRol()->getNombre(),
                    "responsable" => $objUsuario->getRol()->getResponsable()
                ],
                "restaurant" => $objRestaurant->getNombre(),
                "activo" => $objUsuario->getActivo(),
                "fecha_registro" => $objUsuario->getFechaRegistro()
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
    
    /**
     * REGISTRAR
     */
    case "REGISTRAR":
        $documento = Input::POST("documento");
        $nombre = Input::POST("nombre");
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo");
        $usuario = Input::POST("usuario");
        $idRol = Input::POST("rol");
        $clave = Input::POST("clave");
        $clave2 = Input::POST("clave2");

        if($documento == "") throw new Exception("El campo de <b>documento</b> no puede estar vacio.");
        if($nombre == "") throw new Exception("El campo de <b>nombre</b> no puede estar vacio.");
        if($usuario == "") throw new Exception("El campo de <b>usuario</b> no puede estar vacio.");
        if($idRol == "") throw new Exception("El campo de <b>rol</b> no puede estar vacio.");
        if($clave == "") throw new Exception("El campo de <b>clave</b> no puede estar vacio.");

        if($clave != $clave2) throw new Exception("Las contraseñas deben ser iguales.");
        
        if(UsuariosModel::Existe($idRestaurant, $usuario) === TRUE) {
            throw new Exception("El usuario <b>{$usuario}</b> ya existe en el restaurant <b>{$objRestaurant->getNombre()}</b>.");
        }

        $objUsuario = UsuariosModel::Registrar(
            $usuario,
            $idRestaurant,
            $clave,
            $documento,
            $nombre,
            $idRol,
            $direccion,
            $telefono,
            $correo
        );

        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "id" => $objUsuario->getId(),
            "usuario" => $objUsuario->getUsuario(),
            "idRestaurant" => $objUsuario->getIdRestaurant(),
            "documento" => $objUsuario->getDocumento(),
            "nombre" => $objUsuario->getNombre(),
            "rol" =>  $objUsuario->getRol()->getId()
        ];
    break;
    
    /**
     * MODIFICAR
     */
    case "MODIFICAR":
        $idUsuario = Input::POST("idUsuario");
        $objUsuario = new UsuarioModel( $idUsuario );

        if($objUsuario->getIdRestaurant() != $idRestaurant) {
            throw new Exception("No puede modificar un usuario que no pertenece a su restaurant.");
        }

        $usuario = Input::POST("usuario", FALSE);
        $documento = Input::POST("documento", FALSE);
        $nombre = Input::POST("nombre", FALSE);
        $direccion = Input::POST("direccion", FALSE);
        $telefono = Input::POST("telefono", FALSE);
        $correo = Input::POST("correo", FALSE);
        $idRol = Input::POST("acceso", FALSE);
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
            $carpetaImg = DIR_IMG_REST."/".$objUsuario->getIdRestaurant();
            $nombreImg = "usuario-{$objUsuario->getUsuario()}";
            $aux = explode(".", $img['name']);
            $extensionImg = $aux[ sizeof($aux) - 1 ];
            
            /**
             * Subimos la imagen
             */
            SubirImagen($carpetaImg, $nombreImg, $img);

            /**
             * Guardamos en la base de datos
             */
            $objUsuario->setFoto( "{$nombreImg}.{$extensionImg}" );
        }

        /**
         * Otros datos
         */
        if($documento !== FALSE)
        {
            if($documento == "") throw new Exception("El campo <b>documento</b> es obligatorio.");
            $objUsuario->setDocumento( $documento );
        }

        if($nombre !== FALSE)
        {
            if($nombre == "") throw new Exception("El campo <b>nombre</b> es obligatorio.");
            $objUsuario->setNombre( $nombre );
        }

        if($correo !== FALSE)
        {
            if($correo == "") throw new Exception("El campo <b>correo</b> es obligatorio.");
            $objUsuario->setCorreo( $correo );
        }

        if($direccion !== FALSE) $objUsuario->setDireccion( $direccion );
        if($telefono !== FALSE) $objUsuario->setTelefono( $telefono );

        if($usuario !== FALSE && $usuario != $objUsuario->getUsuario()) {
            if($usuario == "") throw new Exception("EL usuario no puede quedar vacio.");
            if(UsuariosModel::Existe($idRestaurant, $usuario) === TRUE) {
                throw new Exception("El usuario <b>{$usuario}</b> ya existe en el restaurant <b>{$objRestaurant->getNombre()}</b>.");
            }

            $objUsuario->setUsuario($usuario);

            if($objUsuario->getId() == Sesion::getUsuario()->getId()) {
                Sesion::Crear($idRestaurant, $objUsuario->getId());
            }
        }

        if($idRol !== FALSE) {
            if($idRol == "") throw new Exception("El campo <b>rol</b> es obligatorio.");
            $objUsuario->setRol( $idRol );
            
            if( RestaurantesModel::CantidadResponsables( $objUsuario->getIdRestaurant() ) <= 0 ) {
                throw new Exception("El resturant debe tener al menos un responsable.");
            }
        }

        if($activo !== FALSE) {
            if($activo == "") throw new Exception("El campo <b>activo</b> es obligatorio.");
            if($objUsuario->getUsuario() == Sesion::getUsuario()->getUsuario() && $activo == "0") {
                throw new Exception("No se puede desactivar el usuario loggeado.");
            }
            $objUsuario->setActivo( $activo );
        }

        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "id" => $objUsuario->getId(),
            "documento" => $objUsuario->getDocumento(),
            "nombre" => $objUsuario->getNombre(),
            "direccion" => $objUsuario->getDireccion(),
            "correo" => $objUsuario->getCorreo(),
            "telefono" => $objUsuario->getTelefono(),
            "usuario" => $objUsuario->getUsuario(),
            "idRol" => $objUsuario->getRol()->getId(),
            "activo" => $objUsuario->getActivo()
        ];
    break;

    /**
     * ELIMINAR
     */
    case "ELIMINAR":
        $idUsuario = Input::POST("idUsuario");
        $objUsuario = new UsuarioModel( $idUsuario );
        
        if($objUsuario->getIdRestaurant() != $idRestaurant) {
            throw new Exception("No puede eliminar un usuario que no pertenece a su restaurant.");
        }

        if($objUsuario->getUsuario() == Sesion::getUsuario()->getUsuario()) {
            throw new Exception("No se puede eliminar el usuario loggeado.");
        }

        $objUsuario->Eliminar();

        if( RestaurantesModel::CantidadResponsables( $objUsuario->getIdRestaurant() ) <= 0 ) {
            throw new Exception("El resturant debe tener al menos un responsable.");
        }
        
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "usuario" => $objUsuario->getUsuario(),
            "nombre" => $objUsuario->getNombre(),
            "documento" => $objUsuario->getDocumento(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    /**
     * OTROS
     */
    default:
        throw new Exception("Acción invalida.");
    break;
}