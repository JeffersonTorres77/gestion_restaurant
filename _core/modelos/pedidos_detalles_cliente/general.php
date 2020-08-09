<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	modelo GENERAL de PEDIDOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidosDetallesClienteModel
{
    /*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($condicional = "")
	{
		if($condicional == "") {
			$query = "SELECT * FROM pedidos A, pedidos_detalles B WHERE A.idPedido = B.idPedido";
		} else {
			$query = "SELECT * FROM pedidos A, pedidos_detalles B WHERE A.idPedido = B.idPedido AND ({$condicional})";
		}

		$datos = Conexion::getSqlite()->Consultar($query);
        return $datos;
	}

	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function SinConfirmar($idRestaurant, $idMesa)
	{
        $idRestaurant = (int) $idRestaurant;
		$idMesa = (int) $idMesa;
		
		$query = "SELECT * FROM pedidos A, pedidos_detalles B WHERE A.idPedido = B.idPedido AND A.idRestaurant = '{$idRestaurant}' AND A.idMesa = '{$idMesa}' AND A.abierto = '1'";
		$datos = Conexion::getSqlite()->Consultar($query);
        return $datos;
	}

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idPedido, $idPlato, $nombrePlato, $idCombo, $nombreCombo, $idAreaMonitoreo, $precioUnitario, $cantidad, $descuento, $nota, $para_llevar)
	{
		//Busca el ID maximo e incrementa en 1
		$idPedidoDetalle = Conexion::getSqlite()->NextID("pedidos_detalles", "idPedidoDetalle");
		$idPedido = (int) $idPedido;
        $idPlato = (int) $idPlato;
        $nombrePlato = Filtro::General($nombrePlato);
        $idCombo = (int) $idCombo;
		$nombreCombo = Filtro::General($nombreCombo);
		$idAreaMonitoreo = (int) $idAreaMonitoreo;
        $precioUnitario = $precioUnitario;
        $cantidad = (int) $cantidad;
        $descuento = $descuento;
        $precioTotal = bcdiv($precioUnitario * $cantidad * (1 - ($descuento / 100)), '1', 2);
        $nota = Filtro::General($nota);
        $para_llevar = boolval( $para_llevar );
        $status = 0;
		$fecha_registro = Time::get();
		$fecha_modificacion = $fecha_registro;
		
		$query = "INSERT  INTO pedidos_detalles (idPedidoDetalle, idPedido, idPlato, nombrePlato, idCombo, nombreCombo, idAreaMonitoreo, precioUnitario, cantidad, descuento, precioTotal, nota, para_llevar, status, fecha_registro, fecha_modificacion)
			VALUES
			('{$idPedidoDetalle}', '{$idPedido}', '{$idPlato}', '{$nombrePlato}', '{$idCombo}', '{$nombreCombo}', '{$idAreaMonitoreo}', '{$precioUnitario}', '{$cantidad}', '{$descuento}', '{$precioTotal}', '{$nota}', '{$para_llevar}', '{$status}', '{$fecha_registro}', '{$fecha_modificacion}')"
		;
		$respuesta = Conexion::getSqlite()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el pedido.<br>".Conexion::getSqlite()->getError());
		}

		$objPedido = new PedidoClienteModel($idPedido);
		return $objPedido;
	}
}