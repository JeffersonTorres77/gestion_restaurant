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
    private $numero;
    private $total;
    private $fecha_registro;

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

    public function getNumero() {
        return $this->numero;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
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
        $this->numero = $datos[0]['numero'];
        $this->total = $datos[0]['total'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
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