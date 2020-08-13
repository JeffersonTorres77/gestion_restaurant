<?php

class MesaModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $status;
	private $activa;
	private $alias;
	private $usuario;
	private $clave;
	private $aux_1;
	private $aux_2;
	private $aux_3;
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

	public function getStatus() {
		return $this->status;
	}

	public function getAlias() {
		return $this->alias;
	}
	
	public function getNombre() {
		return $this->alias;
	}

	public function getUsuario() {
		return $this->usuario;
	}

	public function getClave() {
		return $this->clave;
	}

	public function getAux1() {
		return $this->aux_1;
	}

	public function getAux2() {
		return $this->aux_2;
	}

	public function getAux3() {
		return $this->aux_3;
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

		$query = "SELECT  * FROM mesas WHERE idMesa = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Mesa id: {$id} no encontrada.");
		}

		$this->id = $datos[0]['idMesa'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->status = $datos[0]['status'];
		$this->alias = $datos[0]['alias'];
		$this->usuario = $datos[0]['usuario'];
		$this->clave = $datos[0]['clave'];
		$this->aux_1 = $datos[0]['aux_1'];
		$this->aux_2 = $datos[0]['aux_2'];
		$this->aux_3 = $datos[0]['aux_3'];
		$this->fecha_registro = $datos[0]['fecha_registro'];
		
	}

	/*=======================================================================
	 *
	 *	ELIMINAR
	 *
    =======================================================================*/
    public function Eliminar($idMesa)
    {
    	$query = "DELETE FROM mesas WHERE idMesa = '{$idMesa}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar la Mesa.");
		}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setAlias( $alias ) {
        $alias = Filtro::General($alias);
        $this->set("alias", $alias);
        $this->alias = $alias;
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

	public function setStatus($status) {
		$status = Filtro::General($status);
        $this->set("status", $status);
        $this->status = $status;
	}
    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE mesas SET {$columna} = '{$valor}' WHERE idMesa = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en la Mesa.");
        }
    }
}