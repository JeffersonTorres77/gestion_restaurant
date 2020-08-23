<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de MONEDAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MonedaModel
{
    /*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $nombre;
	private $simbolo;

	/*=======================================================================
	 *
	 *	GETTER
	 *
    =======================================================================*/
	public function getId() {
		return $this->id;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getSimbolo() {
		return $this->simbolo;
	}

	/*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM monedas WHERE idMoneda = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Moneda id: {$id} no encontrada.");
		}

		$this->id = $datos[0]['idMoneda'];
		$this->nombre = $datos[0]['nombre'];
		$this->simbolo = $datos[0]['simbolo'];
	}
}