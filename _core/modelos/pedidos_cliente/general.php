<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	modelo GENERAL de PEDIDOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidosClienteModel
{
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Listado()
    {
        $query = "SELECT * FROM pedidos";
        $datos = Conexion::getSqlite()->Consultar($query);

        return $datos;
	}
	
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Abierto($idRestaurant, $idMesa)
	{
		$idRestaurant = (int) $idRestaurant;
		$idMesa = (int) $idMesa;

		$query = "SELECT idPedido FROM pedidos WHERE idRestaurant = '{$idRestaurant}' AND idMesa = '{$idMesa}' AND abierto = '1'";
		$datos = Conexion::getSqlite()->Consultar($query);

		if(sizeof($datos) == 0) return FALSE;

		$idPedido = $datos[0]['idPedido'];
		$objPedido = new PedidoClienteModel($idPedido);
		return $objPedido;
	}

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $idMesa)
	{
		//Busca el ID maximo e incrementa en 1
		$idPedido = Conexion::getSqlite()->NextID("pedidos", "idPedido");
		$idRestaurant = (int) $idRestaurant;
		$idMesa = (int) $idMesa;
		$abierto = TRUE;
		$fecha_registro = Time::get();
		
		$query = "INSERT  INTO pedidos (idPedido, idRestaurant, idMesa, abierto, fecha_registro)
			VALUES
			('{$idPedido}', '{$idRestaurant}', '{$idMesa}', '{$abierto}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getSqlite()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el pedido.");
		}

		$objPedido = new PedidoClienteModel($idPedido);
		return $objPedido;
	}
}