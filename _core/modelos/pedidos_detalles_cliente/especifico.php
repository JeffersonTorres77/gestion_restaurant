<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de PEDIDOS DE CLIENTE
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidoDetallesClienteModel
{
    /*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idPedido;
	private $idPlato;
	private $nombrePlato;
	private $idCombo;
	private $nombreCombo;
	private $precioUnitario;
    private $cantidad;
	private $descuento;
	private $precioTotal;
	private $nota;
	private $status;
	private $para_llevar;
	private $aux_1;
	private $aux_2;
	private $aux_3;
	private $fecha_registro;
	private $fecha_modificacion;
    
    /*=======================================================================
	 *
	 *	GETTER
	 *
	=======================================================================*/
	public function getId() {
		return $this->id;
	}

	public function getIdPedido() {
		return $this->idPedido;
	}

	public function getIdPlato() {
		return $this->idPlato;
	}

	public function getNombrePlato() {
		return $this->nombrePlato;
	}

	public function getIdCombo() {
		return $this->idCombo;
	}

	public function getNombreCombo() {
		return $this->nombreCombo;
	}

	public function getPrecioUnitario() {
		return $this->precioUnitario;
	}

	public function getCantidad() {
		return $this->cantidad;
	}

	public function getDescuento() {
		return $this->descuento;
	}

	public function getPrecioTotal() {
		return $this->precioTotal;
	}

	public function getNota() {
		return $this->nota;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getParaLlevar() {
		return $this->para_llevar;
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

	public function getFechaModificacion() {
		return $this->fecha_modificacion;
	}

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM pedidos_detalles WHERE idPedidoDetalle = '{$id}'";
		$datos = Conexion::getSqlite()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Pedido detalle id: {$id} no encontrado.");
		}
		
		$this->id = $datos[0]['idPedidoDetalle'];
		$this->idPedido = $datos[0]['idPedido'];
		$this->idPlato = $datos[0]['idPlato'];
		$this->nombrePlato = $datos[0]['nombrePlato'];
		$this->idCombo = $datos[0]['idCombo'];
		$this->nombreCombo = $datos[0]['nombreCombo'];
		$this->precioUnitario = $datos[0]['precioUnitario'];
		$this->cantidad = $datos[0]['cantidad'];
		$this->descuento = $datos[0]['descuento'];
		$this->precioTotal = $datos[0]['precioTotal'];
		$this->nota = $datos[0]['nota'];
		$this->status = $datos[0]['status'];
		$this->para_llevar = $datos[0]['para_llevar'];
		$this->aux_1 = $datos[0]['aux_1'];
		$this->aux_2 = $datos[0]['aux_2'];
		$this->aux_3 = $datos[0]['aux_3'];
		$this->fecha_registro = $datos[0]['fecha_registro'];
		$this->fecha_modificacion = $datos[0]['fecha_modificacion'];
    }

    /*=======================================================================
	 *
	 *	
	 *
	=======================================================================*/
	public function Eliminar()
	{
		$query = "DELETE FROM pedidos_detalles WHERE idPedidoDetalle = '{$this->id}'";
		$respuesta = Conexion::getSqlite()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un problema al intentar eliminar el detalle del pedido.");
		}
		return $this->id;
	}

    /*=======================================================================
	 *
	 *	
	 *
	=======================================================================*/
	public function EliminarPorCombo()
	{
		$query = "SELECT idPedidoDetalle FROM pedidos_detalles WHERE idPedido = '{$this->idPedido}' AND idCombo = '{$this->idCombo}'";
		$datos = Conexion::getSqlite()->Consultar($query);

		$query = "DELETE FROM pedidos_detalles WHERE idPedido = '{$this->idPedido}' AND idCombo = '{$this->idCombo}'";
		$respuesta = Conexion::getSqlite()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un problema al intentar eliminar por combo el detalle del pedido.");
		}

		$data = [];
		foreach($datos as $fila)
		{
			array_push($data, $fila['idPedidoDetalle']);
		}

		return $data;
	}

	/*=======================================================================
	 *
	 *	
	 *
	=======================================================================*/
	public function setStatus($intStatus)
	{
		$intStatus = (int) $intStatus;
		$fecha_modificacion = Time::get();

		$query = "UPDATE pedidos_detalles SET status = '{$intStatus}', fecha_modificacion = '{$fecha_modificacion}' WHERE idPedidoDetalle = '{$this->id}'";
		$respuesta = Conexion::getSqlite()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Ocurrio un error al intentar cambiar el status al detalle del pedido.");
		}
	}
}