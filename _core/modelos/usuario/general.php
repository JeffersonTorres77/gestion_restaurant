<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class UsuariosModel
{
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function BuscarPorUsuario($idRestaurant, $usuario)
    {
        $query = "SELECT idUsuario FROM usuarios WHERE idRestaurant = '{$idRestaurant}' AND usuario = '{$usuario}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) == 0) {
            throw new Exception("El usuario <b>{$usuario}</b> no existe en el restaurant <b>codigo: {$idRestaurant}</b>.");
        }

        $idUsuario = $datos[0]['idUsuario'];
        $objUsuario = new UsuarioModel($idUsuario);
        return $objUsuario;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Existe($idRestaurant, $usuario)
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuarios WHERE idRestaurant = '{$idRestaurant}' AND usuario = '{$usuario}'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }

	/**
     * Listado
     * Array(
     *      condicional: string
     *      cantMostrar: number (> 1)
     *      pagina: number (> 0)
     *      ordenar_por: string
     *      ordenar_tipo: string (ASC / DESC)
     *  )
     */
	public static function Listado($condicional, $par = [])
	{
        /**
         * Iniciar
         */
        $order_by = "";
        $where = "";
        $limit = "";

        /**
         * Where
         */        
        if($condicional != "")
        {
            $where = "WHERE {$condicional}";
        }

        /**
         * Limit
         */
        if(isset($par['cantMostrar']))
        {
            $cantMostrar = (int) $par['cantMostrar'];
            if($cantMostrar < 1) $cantMostrar = 10;
            if(isset($par['pagina']))
            {
                $pagina = (int) $par['pagina'];
                if($pagina < 1) $pagina = 1;
                $inicio = ($pagina - 1) * $cantMostrar;
                $limit = "LIMIT {$inicio}, {$cantMostrar}";
            }
            else
            {
                $limit = "LIMIT {$cantMostrar}";
            }   
        }

        /**
         * Order by
         */
        if(isset($par['ordenar_por']))
        {
            $key = $par['ordenar_por'];
            $type = (isset($par['ordenar_tipo'])) ? $par['ordenar_tipo'] : 'ASC';
            if($type != "ASC" && $type != "DESC") $type = "ASC";
            $order_by = "ORDER BY {$key} {$type}";
        }

        /**
         * Consulta
         */
        $query = "SELECT * FROM usuarios {$where} {$order_by} {$limit}";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

    /*============================================================================
	 *
	 *	
	 *
	============================================================================*/
    public static function Total($condicional = "")
    {
        $where = ( $condicional != "" ) ? "WHERE {$condicional}" : '';

        $query = "SELECT COUNT(*) AS cantidad FROM usuarios {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

    /*============================================================================
	 *
	 *	
	 *
	============================================================================*/
    public static function BuscarPorCorreo($correo)
    {
        $correo = Filtro::General($correo);

        $query = "SELECT * FROM usuarios WHERE correo = '{$correo}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("Correo <b>{$correo}</b> no encontrado.");
        }

        $objUsuario = new UsuarioModel($datos[0]['idUsuario']);
        return $objUsuario;
    }
    
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Registrar($usuario, $idRestaurant, $clave, $documento, $nombre, $idRol, $direccion, $telefono, $correo)
    {
        $idUsuario = Conexion::getMysql()->NextID("usuarios", "idUsuario");
        $idRestaurant = (int) $idRestaurant;
        $usuario = Filtro::General($usuario);
        $clave = Filtro::General($clave);
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);
        $idRol = (int) $idRol;
        $direccion = Filtro::General($direccion);
        $telefono = Filtro::General($telefono);
        $correo = Filtro::General($correo);
        $activo = (int) TRUE;
        $fecha_registro = Time::get();
        $fecha_modificacion = $fecha_registro;

        $query = "INSERT INTO usuarios
        (idUsuario, idRestaurant, usuario, clave, documento, nombre, idRol, direccion, telefono, correo, activo, fecha_registro, fecha_modificacion)
        VALUES
        ('{$idUsuario}', '{$idRestaurant}', '{$usuario}', '{$clave}', '{$documento}', '{$nombre}', '{$idRol}', '{$direccion}', '{$telefono}', '{$correo}', '{$activo}', '{$fecha_registro}', '{$fecha_modificacion}')";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar registrar el usuario.<br>{$query}");
        }

        $objUsuario = new UsuarioModel($idUsuario);
        return $objUsuario;
    }
}