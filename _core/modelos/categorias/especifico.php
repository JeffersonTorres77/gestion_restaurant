<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de CATEGORIAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class CategoriaModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $nombre;
	private $idAreaMonitoreo;
	private $fecha_registro;

	/*=======================================================================
	 *
	 *	GETTER
	 *
    =======================================================================*/
	public function getId() {
		return $this->id;
	}

	public function getIdRestaurant() {
		return $this->idRestaurant;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getIdAreaMonitoreo() {
		return $this->idAreaMonitoreo;
	}

	public function getFechaRegistro() {
		return $this->fecha_registro;
	}

	/*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM categorias WHERE idCategoria = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Categoria id: {$id} no encontrada.");
		}

		$this->id = $datos[0]['idCategoria'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->nombre = $datos[0]['nombre'];
		$this->idAreaMonitoreo = $datos[0]['idAreaMonitoreo'];
		$this->fecha_registro = $datos[0]['fecha_registro'];
	}

	/*=======================================================================
	 *
	 *	ELIMINAR
	 *
    =======================================================================*/
    public function Eliminar($idReemplazo)
    {
    	$query = "UPDATE platos SET idCategoria = '{$idReemplazo}' WHERE idCategoria = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar reemplazar la categoria en los platos.");
		}
		
		$query = "DELETE FROM combos_categorias WHERE idCategoria = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar la categoria de los combos.");
		}

    	$query = "DELETE FROM categorias WHERE idCategoria = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar la categoria.");
    	}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setNombre( $nombre ) {
        $nombre = Filtro::General(strtoupper($nombre));
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
    }

    public function setIdAreaMonitoreo( $idAreaMonitoreo ) {
        $idAreaMonitoreo = (int) $idAreaMonitoreo;
        $this->set("idAreaMonitoreo", $idAreaMonitoreo);
        $this->idAreaMonitoreo = $idAreaMonitoreo;
    }

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE categorias SET {$columna} = '{$valor}' WHERE idCategoria = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en la categoria.");
        }
    }
}