<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de MENU_B
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MenuBModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $idMenuA;
    private $nombre;
    private $img;
    private $link;

	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }

    public function getIdMenuA() {
        return $this->idMenuA;
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

	/*============================================================================
	 *
	 *	Setter
	 *
    ============================================================================*/
    public function setNombre($nombre) {
        $nombre = Filtro::General($nombre);

        $query = "UPDATE menus_b SET nombre = '{$nombre}' WHERE idMenuB = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el nombre.");

        $this->nombre = $nombre;
    }

    public function setImg($img) {
        $img = Filtro::General($img);

        $query = "UPDATE adm_menus_b SET img = '{$img}' WHERE idMenuB = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el img.");

        $this->img = $img;
    }

    public function setLink($link) {
        $link = Filtro::General($link);

        $query = "UPDATE adm_menus_b SET link = '{$link}' WHERE idMenuB = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el link.");

        $this->link = $link;
    }

	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idMenuB)
    {
        $idMenuB = (int) $idMenuB;

        $query = "SELECT * FROM menus_b WHERE idMenuB = '{$idMenuB}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("Menu B [id: {$idMenuB}] no encontrado.");
        }

        $this->id = $datos[0]['idMenuB'];
        $this->idMenuA = $datos[0]['idMenuA'];
        $this->nombre = $datos[0]['nombre'];
        $this->img = $datos[0]['img'];
        $this->link = $datos[0]['link'];
    }

	/*============================================================================
	 *
	 *	Verificar
	 *
    ============================================================================*/
    public function Verificar($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT COUNT(*) as cantidad FROM permisos_b WHERE idMenuB = '{$this->id}' AND idRol = '{$idRol}'";
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
            $query = "INSERT INTO permisos_b (idRol, idMenuB) VALUES ('{$idRol}', '{$this->id}')";
        }
        else
        {
            $query = "DELETE FROM permisos_b WHERE idRol = '{$idRol}' AND idMenuB = '{$this->id}'";
        }

        //Ejecutamos
        $resp = Conexion::getMysql()->Ejecutar($query);
        if(!$resp) {
            throw new Exception("Error al intentar modificar los permisos el menu tipo B [id: {$this->id}]. ".Conexion::getMysql()->getError());
        }
        
        return $resp;
    }
}