<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de MENU_A
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MenuAModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $nombre;
    private $img;
    private $link;
    private $con_opciones;

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

    public function getImg() {
        return $this->img;
    }

    public function getLink() {
        return $this->link;
    }

    public function getConOpciones() {
        return $this->con_opciones;
    }

	/*============================================================================
	 *
	 *	Setter
	 *
    ============================================================================*/
    public function setNombre($nombre) {
        $nombre = Filtro::General($nombre);

        $query = "UPDATE menus_a SET nombre = '{$nombre}' WHERE idMenuA = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el nombre.");

        $this->nombre = $nombre;
    }

    public function setImg($img) {
        $img = Filtro::General($img);

        $query = "UPDATE menus_a SET img = '{$img}' WHERE idMenuA = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el img.");

        $this->img = $img;
    }

    public function setLink($link) {
        $link = Filtro::General($link);

        $query = "UPDATE menus_a SET link = '{$link}' WHERE idMenuA = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el link.");

        $this->link = $link;
    }

	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idMenuA)
    {
        $idMenuA = (int) $idMenuA;

        $query = "SELECT * FROM menus_a WHERE idMenuA = '{$idMenuA}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("Menu A [id: {$idMenuA}] no encontrado.");
        }

        $this->id = $datos[0]['idMenuA'];
        $this->nombre = $datos[0]['nombre'];
        $this->img = $datos[0]['img'];
        $this->link = $datos[0]['link'];
        $this->con_opciones = boolval( $datos[0]['con_opciones'] );
    }

	/*============================================================================
	 *
	 *	Verificar
	 *
    ============================================================================*/
    public function Verificar($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) as cantidad FROM permisos_a WHERE idMenuA = '{$this->id}' AND idRol = '{$idRol}'";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }

	/*============================================================================
	 *
	 *	Cambiar permisos
	 *
    ============================================================================*/
    public function CambiarPermiso($idRol, $darPermiso)
    {
        $idRol = (int) $idRol;
        
        if($darPermiso)
        {
            $query = "INSERT INTO permisos_a (idRol, idMenuA) VALUES ('{$idRol}', '{$this->id}')";
        }
        else
        {
            $query = "DELETE FROM permisos_a WHERE idRol = '{$idRol}' AND idMenuA = '{$this->id}'";
        }

        //Ejecutamos
        $resp = Conexion::getMysql()->Ejecutar($query);
        if(!$resp) {
            throw new Exception("Error al intentar modificar los permisos el menu tipo A [id: {$this->id}]. ".Conexion::getMysql()->getError());
        }
        
        return $resp;
    }

	/*============================================================================
	 *
	 *	Listado de submenus del menu
	 *
    ============================================================================*/
    public function Opciones()
    {
        if(!$this->con_opciones) {
            return Array();
        }

        $query = "SELECT * FROM menus_b WHERE idMenuA = '{$this->id}' ORDER BY nombre ASC";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
}