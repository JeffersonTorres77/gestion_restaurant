<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de ROL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RolModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $nombre;
    private $descripcion;
    private $responsable;
    private $fecha_registro;

	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getResponsable() {
        return $this->responsable;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT * FROM roles WHERE idRol = '{$idRol}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El rol {$idRol} no esta registrado.");
        }

        $this->id = $datos[0]['idRol'];
        $this->nombre = $datos[0]['nombre'];
        $this->descripcion = $datos[0]['descripcion'];
        $this->responsable = boolval( $datos[0]['responsable'] );
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Setear permisos A
	 *
    ============================================================================*/
    public function setPermisosA($idMenuA, $permitido)
    {
        $idMenuA = (int) $idMenuA;
        $permitido = boolval( $permitido );

        if($permitido) {
            $query = "INSERT INTO permisos_a (idRol, idMenuA) VALUES ('{$this->id}', '{$idMenuA}')";
        } else {
            $query = "DELETE FROM permisos_a WHERE idRol = '{$this->id}' AND idMenuA = '{$idMenuA}'";
        }

        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar los permisos A del rol.");
        }
    }
    
	/*============================================================================
	 *
	 *	Setear permisos B
	 *
    ============================================================================*/
    public function setPermisosB($idMenuB, $permitido)
    {
        $idMenuB = (int) $idMenuB;
        $permitido = boolval( $permitido );

        if($permitido) {
            $query = "INSERT INTO permisos_b (idRol, idMenuB) VALUES ('{$this->id}', '{$idMenuB}')";
        } else {
            $query = "DELETE FROM permisos_b WHERE idRol = '{$this->id}' AND idMenuB = '{$idMenuB}'";
        }

        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar los permisos B del rol.");
        }
    }
    
	/*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public function Eliminar($idReemplazo)
    {
        $idReemplazo = (int) $idReemplazo;

        $query = "UPDATE usuarios SET idRol = '{$idReemplazo}' WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar aplicar el rol de reemplazo.");
        }

        $query = "DELETE FROM permisos_a WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar limpiar la tabla de los permisos (A).");
        }

        $query = "DELETE FROM permisos_b WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar limpiar la tabla de los permisos (B).");
        }

        $query = "DELETE FROM roles WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar eliminar el rol.");
        }
    }

    /*============================================================================
	 *
	 *	SETTER
	 *
    ============================================================================*/
    public function setNombre( $nombre ) {
        $nombre = Filtro::General($nombre);
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
    }
    
    public function setDescripcion( $descripcion ) {
        $descripcion = Filtro::General($descripcion);
        $this->set("descripcion", $descripcion);
        $this->descripcion = $descripcion;
    }
    
    public function setResponsable( $responsable ) {
        $responsable = boolval($responsable);
        $this->set("responsable", $responsable);
        $this->responsable = $responsable;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE roles SET {$columna} = '{$valor}' WHERE idRol = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en el rol.");
        }
    }
}