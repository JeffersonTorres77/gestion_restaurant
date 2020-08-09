<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de AREA DE MONITOREO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class AreaMonitoreoModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $nombre;

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

	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM areas_monitoreo WHERE idAreaMonitoreo = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("El area de monitoreo id: {$id} no encontrado.");
		}

		$this->id = $datos[0]['idAreaMonitoreo'];
		$this->nombre = $datos[0]['nombre'];
	}
}