<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de ADMIN_MENU_A
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class AdminMenuAModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $label;
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

        $query = "UPDATE adm_menus_a SET nombre = '{$nombre}' WHERE idMenuA = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el nombre.");

        $this->nombre = $nombre;
    }

    public function setImg($img) {
        $img = Filtro::General($img);

        $query = "UPDATE adm_menus_a SET img = '{$img}' WHERE idMenuA = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) throw new Exception("Ocurrio un error al intentar modificar el img.");

        $this->img = $img;
    }

    public function setLink($link) {
        $link = Filtro::General($link);

        $query = "UPDATE adm_menus_a SET link = '{$link}' WHERE idMenuA = '{$this->id}'";
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

        $query = "SELECT * FROM adm_menus_a WHERE idMenuA = '{$idMenuA}'";
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
    public function Verificar($idAcceso)
    {
        $idAcceso = (int) $idAcceso;

        $query = "SELECT COUNT(*) as cantidad FROM adm_permisos_a WHERE idMenuA = '{$this->id}' AND idAcceso = '{$idAcceso}'";
        $datos = Conexion::getSqlServer2()->Consultar($query);

        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
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

        $query = "SELECT * FROM adm_menus_b WHERE idMenuA = '{$this->id}' ORDER BY label ASC";
        $datos = Conexion::getSqlServer2()->Consultar($query);
        return $datos;
    }
}