<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE LOS USUARIOS
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
        if($buscar !== FALSE)
        {
            $condicional = "nombre LIKE '%{$buscar}%' OR ";
            $condicional .= "cedula LIKE '%{$buscar}%' OR ";
            $condicional .= "usuario LIKE '%{$buscar}%'";

            $par = [];
            $par['cantMostrar'] = $cantMostrar;
            $par['pagina'] = $pagina;
            $par['ordenar_por'] = $order_key;
            $par['ordenar_tipo'] = $order_type;

            $usuarios = AdminUsuariosModel::Listado( $condicional, $par );
            $total_filas = AdminUsuariosModel::Total( $condicional );
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

            $usuarios = AdminUsuariosModel::Listado( '', $par );
            $total_filas = AdminUsuariosModel::Total();
        }

        /**
         * Organizamos la salida
         */
        $datos = [];
        for($I=0; $I<sizeof($usuarios); $I++)
        {
            $datos[$I] = [
                "nombre" => $usuarios[$I]['nombre'],
                "cedula" => $usuarios[$I]['cedula'],
                "usuario" => $usuarios[$I]['usuario'],
                "fecha_registro" => $usuarios[$I]['fecha_registro']
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
        $nombre = Input::POST("nombre");
        $cedula = Input::POST("cedula");
        $usuario = Input::POST("usuario");
        $clave = Input::POST("clave");

        if( AdminUsuariosModel::Existe( $usuario ) ) {
            throw new Exception("El usuario '{$usuario}' ya existe.");
        }

        $objUsuario = AdminUsuariosModel::Registrar($usuario, $clave, $nombre, $cedula);
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    /**
     * MODIFICAR
     */
    case "MODIFICAR":
        $usuario = ( Input::POST("usuario", FALSE) === FALSE ) ? Sesion::getUsuario()->getUsuario() : Input::POST("usuario");
        $nombre = Input::POST("nombre", FALSE);
        $cedula = Input::POST("cedula", FALSE);
        $clave = Input::POST("clave", FALSE);

        if($clave !== FALSE && $clave == "") {
            throw new Exception("La contraseña no puede estar vacia.");
        }

        $objUsuario = new AdminUsuarioModel($usuario);
        if($nombre != FALSE) $objUsuario->setNombre( $nombre );
        if($cedula != FALSE) $objUsuario->setCedula( $cedula );
        if($clave != FALSE) $objUsuario->setClave( $clave );
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    /**
     * ELIMINAR
     */
    case "ELIMINAR":
        $usuario = Input::POST("usuario");
        $objUsuario = new AdminUsuarioModel($usuario);

        if($objUsuario->getUsuario() == Sesion::getUsuario()->getUsuario()) {
            throw new Exception("No puede eliminar su usuario loggeado.");
        }

        $objUsuario->Eliminar();
        Conexion::getMysql()->Commit();

        $respuesta['cuerpo'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}