<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de PEDIDOS DE CLIENTE
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidoClienteModel
{
    /*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $idMesa;
	private $abierto;
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

    public function getIdMesa() {
        return $this->idMesa;
    }

    public function getAbierto() {
        return $this->abierto;
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

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM pedidos WHERE idPedido = '{$id}'";
		$datos = Conexion::getSqlite()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Pedido id: {$id} no encontrado.");
		}
		
		$this->id = $datos[0]['idPedido'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
        $this->idMesa = $datos[0]['idMesa'];
        $this->abierto = boolval( $datos[0]['abierto'] );
		$this->aux_1 = $datos[0]['aux_1'];
		$this->aux_2 = $datos[0]['aux_2'];
		$this->aux_3 = $datos[0]['aux_3'];
		$this->fecha_registro = $datos[0]['fecha_registro'];
    }

    /*=======================================================================
	 *
	 *	
	 *
	=======================================================================*/
	public function getDetalles()
	{
		$query = "SELECT  * FROM pedidos_detalles WHERE idPedido = '{$this->id}'";
		$datos = Conexion::getSqlite()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Detalles del pedido id: {$id} no encontrado.");
		}

		return $datos;
	}

    /*=======================================================================
	 *
	 *	
	 *
	=======================================================================*/
	public function setAbierto($valor)
	{
		$valor = boolval($valor);

		$query = "UPDATE pedidos SET abierto = '{$valor}' WHERE idPedido = '{$this->id}'";
		$respuesta = Conexion::getSqlite()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un error al intentar cerrar el pedido.");
		}
	}
}