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

    public function getNumero() {
        return $this->numero;
    }

    public function getTotal() {
        return $this->total;
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
        $this->numero = $datos[0]['numero'];
        $this->total = $datos[0]['total'];
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