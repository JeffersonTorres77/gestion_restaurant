<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de FACTURAS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class FacturaModel
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $idRestaurant;
    private $idMesa;
    private $idMoneda;
    private $subtotal;
    private $iva;
    private $fecha;
    private $hora;

    /*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }

    public function getIdRestaurant() {
        return $this->idRestaurant;
    }

    public function getIdMesa() {
        return $this->idMesa;
    }

    public function getIdMoneda() {
        return $this->idMoneda;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getIva() {
        return $this->iva;
    }

    public function getTotal() {
        return bcdiv($this->subtotal * (1 + ($this->iva / 100)), '1', 2);
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($id)
    {
        $id = (int) $id;

        $query = "SELECT * FROM facturas WHERE idFactura = '{$id}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("La factura {$id} no esta registrada.");
        }

        $this->id = $datos[0]['idFactura'];
        $this->idRestaurant = $datos[0]['idRestaurant'];
        $this->idMesa = $datos[0]['idMesa'];
        $this->idMoneda = $datos[0]['idMoneda'];
        $this->subtotal = $datos[0]['subtotal'];
        $this->iva = $datos[0]['iva'];
        $this->fecha = $datos[0]['fecha'];
        $this->hora = $datos[0]['hora'];
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function getItems()
    {
        $query = "SELECT * FROM facturas_detalles WHERE idFactura = '{$this->id}'";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
}