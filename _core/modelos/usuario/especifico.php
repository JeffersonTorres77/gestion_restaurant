<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class UsuarioModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $idRestaurant;
    private $usuario;
    private $clave;
    private $nombre;
    private $documento;
    private $rol;
    private $direccion;
    private $telefono;
    private $correo;
    private $foto;
    private $activo;
    private $aux_1;
    private $aux_2;
    private $aux_3;
    private $fecha_registro;
    
	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }

    public function getIdRestaurant() {
        return $this->idRestaurant;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDocumento() {
        return $this->documento;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getFoto() {
        $ruta = DIR_IMG_REST."/".$this->idRestaurant."/".$this->foto;
        $link = HOST_IMG_REST."/".$this->idRestaurant."/".$this->foto;
        if(file_exists($ruta) && is_File($ruta))
        {
            return $link;
        }
        else
        {
            return HOST.IMG_USUARIO_DEFECTO;
        }
    }

    public function getActivo() {
        return $this->activo;
    }
    public function getAux_1() {
        return $this->aux_1;
    }

    public function getAux_2() {
        return $this->aux_2;
    }

    public function getAux_3() {
        return $this->aux_3;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($id)
    {
        $id = (int) $id;

        $query = "SELECT * FROM usuarios WHERE idUsuario = '{$id}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El usuario {$id} no esta registrado.");
        }

        $this->id = $datos[0]['idUsuario'];
        $this->idRestaurant = $datos[0]['idRestaurant'];
        $this->usuario = $datos[0]['usuario'];
        $this->clave = $datos[0]['clave'];
        $this->nombre = $datos[0]['nombre'];
        $this->documento = $datos[0]['documento'];

        $idRol = $datos[0]['idRol'];
        $this->rol = new RolModel($idRol);
        
        $this->direccion = $datos[0]['direccion'];
        $this->telefono = $datos[0]['telefono'];
        $this->correo = $datos[0]['correo'];
        $this->foto = $datos[0]['foto'];
        $this->activo = boolval( $datos[0]['activo'] );
        $this->aux_1 = $datos[0]['aux_1'];
        $this->aux_2 = $datos[0]['aux_2'];
        $this->aux_3 = $datos[0]['aux_3'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public function Eliminar()
    {
        $query = "DELETE FROM usuarios WHERE idUsuario = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar eliminar el usuario.");
        }
    }

    /*============================================================================
	 *
	 *	SETTER
	 *
    ============================================================================*/
    public function setDocumento( $documento ) {
        $documento = Filtro::General($documento);
        $this->set("documento", $documento);
        $this->documento = $documento;
    }

    public function setNombre( $nombre ) {
        $nombre = Filtro::General($nombre);
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
    }

    public function setDireccion( $direccion ) {
        $direccion = Filtro::General($direccion);
        $this->set("direccion", $direccion);
        $this->direccion = $direccion;
    }
    
    public function setTelefono( $telefono ) {
        $telefono = Filtro::General($telefono);
        $this->set("telefono", $telefono);
        $this->telefono = $telefono;
    }
    
    public function setCorreo( $correo ) {
        $correo = Filtro::General($correo);
        $this->set("correo", $correo);
        $this->correo = $correo;
    }
    
    public function setFoto( $foto ) {
        $foto = Filtro::General($foto);
        $this->set("foto", $foto);
        $this->foto = $foto;
    }

    public function setUsuario( $usuario ) {
        $usuario = Filtro::General($usuario);
        $this->set("usuario", $usuario);
        $this->usuario = $usuario;
    }

    public function setClave( $clave ) {
        $clave = Filtro::General($clave);
        $this->set("clave", $clave);
        $this->clave = $clave;
    }

    public function setRol( $idRol ) {
        $idRol = (int) $idRol;
        $this->set("idRol", $idRol);
        $this->rol = new RolModel( $idRol );
    }

    public function setActivo( $activo ) {
        $activo = (int) $activo;
        $this->set("activo", $activo);
        $this->activo = boolval( $activo );
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE usuarios SET {$columna} = '{$valor}' WHERE idUsuario = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en el usuario.");
        }
    }
}