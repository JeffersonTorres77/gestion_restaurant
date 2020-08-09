<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de PLATOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PlatoModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $idCategoria;
	private $nombre;
	private $descripcion;
	private $imagen;
	private $activo;
	private $precioCosto;
	private $precioVenta;
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

	public function getidCategoria() {
		return $this->idCategoria;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getdescripcion() {
		return $this->descripcion;
	}

    public function getImagen() {
        $ruta = DIR_IMG_REST."/".$this->idRestaurant."/".$this->imagen;
        $link = HOST_IMG_REST."/".$this->idRestaurant."/".$this->imagen;
        if(file_exists($ruta) && is_File($ruta))
        {
            return $link;
        }
        else
        {
            return HOST.IMG_PLATO_DEFECTO;
        }
    }

	public function getactivo() {
		return $this->activo;
	}

	public function getprecioCosto() {
		return $this->precioCosto;
	}

	public function getprecioVenta() {
		return $this->precioVenta;
	}

	public function getaux_1() {
		return $this->aux_1;
	}

	public function getaux_2() {
		return $this->aux_2;
	}

	public function getaux_3() {
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

		$query = "SELECT  * FROM platos WHERE idPlato = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Plato id: {$id} no encontrada.");
		}
		
		$this->id = $datos[0]['idPlato'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->idCategoria = $datos[0]['idCategoria'];
		$this->nombre = $datos[0]['nombre'];
		$this->descripcion = $datos[0]['descripcion'];
		$this->imagen = $datos[0]['imagen'];
		$this->activo = boolval( $datos[0]['activo'] );
		$this->precioCosto = $datos[0]['precioCosto'];
		$this->precioVenta = $datos[0]['precioVenta'];
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
    public function Eliminar()
    {
		$query = "DELETE FROM combos_platos WHERE idPlato = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el Plato de los combos.");
		}
		
		$query = "DELETE FROM platos WHERE idPlato = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el Plato.");
    	}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setNombre( $nombre ) {
        $nombre = Filtro::General(strtoupper($nombre));
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
	}

    public function setDescripcion( $descripcion ) {
        $descripcion = Filtro::General($descripcion);
        $this->set("descripcion", $descripcion);
        $this->descripcion = $descripcion;
    }
	
    public function setIdCategoria( $idCategoria ) {
		$idCategoria = (int) $idCategoria;
        $this->set("idCategoria", $idCategoria);
        $this->idCategoria = $idCategoria;
    }

    public function setImagen( $imagen) {
        $imagen= Filtro::General($imagen);
        $this->set("imagen", $imagen);
        $this->imagen = $imagen;
    }

    public function setActivo( $activo) {
        $activo = (int) $activo;
        $this->set("activo", $activo);
        $this->activo = $activo;
    }

    public function setPrecioCosto( $precioCosto) {
        $precioCosto = Filtro::General( $precioCosto );
        $this->set("precioCosto", $precioCosto);
        $this->precioCosto = $precioCosto;
    }

    public function setPrecioVenta( $precioVenta) {
        $precioVenta = Filtro::General( $precioVenta );
        $this->set("precioVenta", $precioVenta);
        $this->precioVenta = $precioVenta;
    }
	
    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE platos SET {$columna} = '{$valor}' WHERE idPlato = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' de la tabla de Platos.");
        }
    }
}