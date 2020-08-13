<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de COMBOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class ComboModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $nombre;
	private $imagen;
	private $descripcion;
	private $descuento;
	private $activo;
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

	public function getNombre() {
		return $this->nombre;
	}

	public function getdescripcion() {
		return $this->descripcion;
	}

    public function getImagen() {
		return HOST . $this->imagen;
    }

	public function getDescuento() {
		return $this->descuento;
	}

	public function getactivo() {
		return $this->activo;
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

		$query = "SELECT  * FROM combos WHERE idCombo = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Combo id: {$id} no encontrada.");
		}
		
		$this->id = $datos[0]['idCombo'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->nombre = $datos[0]['nombre'];
		$this->imagen = $datos[0]['imagen'];
		$this->descripcion = $datos[0]['descripcion'];
		$this->descuento = $datos[0]['descuento'];
		$this->activo = boolval( $datos[0]['activo'] );
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
		$query = "DELETE FROM combos_platos WHERE idCombo = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar los detalles del combo.");
		}
		
		$query = "DELETE FROM combos WHERE idCombo = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el combo.");
    	}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setNombre( $nombre ) {
        $nombre = Filtro::General($nombre);
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
	}

    public function setImagen( $imagen) {
        $imagen= "recursos/restaurantes/{$this->idRestaurant}/$imagen";
        $this->set("imagen", $imagen);
        $this->imagen = $imagen;
    }

    public function setDescripcion( $descripcion ) {
        $descripcion = Filtro::General($descripcion);
        $this->set("descripcion", $descripcion);
        $this->descripcion = $descripcion;
    }

    public function setDescuento( $descuento ) {
        $descuento = Filtro::General($descuento);
        $this->set("descuento", $descuento);
        $this->descuento = $descuento;
    }

    public function setActivo( $activo) {
        $activo = (int) $activo;
        $this->set("activo", $activo);
        $this->activo = boolval( $activo );
    }
	
    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE combos SET {$columna} = '{$valor}' WHERE idCombo = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' de la tabla de combos.");
        }
	}
	
	/*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/

	/*=======================================================================
	 *
	 * Obtener categorias
	 *
	=======================================================================*/
	public function getCategorias()
	{
		$query = "SELECT * FROM combos_categorias WHERE idCombo = '{$this->id}'";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}

	/*=======================================================================
	 *
	 *	Agregar categoria
	 *
	=======================================================================*/
	public function addCategoria($idCategoria, $cantidad)
	{
		$idComboCategoria = Conexion::getMysql()->NextID("combos_categorias", "idComboCategoria");
		$idCombo = (int) $this->id;
		$idCategoria = (int) $idCategoria;
		$cantidad = (int) $cantidad;
		$aux_1 = "";
		$aux_2 = "";
		$aux_3 = "";
		$fecha_registro = Time::get();

		$query = "INSERT INTO combos_categorias (idComboCategoria, idCombo, idCategoria, cantidad, aux_1, aux_2, aux_3, fecha_registro) VALUES ('{$idComboCategoria}', '{$idCombo}', '{$idCategoria}', '{$cantidad}', '{$aux_1}', '{$aux_2}', '{$aux_3}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Error al intentar agregar una categoria al combo.");
		}
	}

	/*=======================================================================
	 *
	 *	Reset categorias
	 *
	=======================================================================*/
	public function resetCategorias()
	{
		$query = "DELETE FROM combos_categorias WHERE idCombo = '{$this->id}'";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Error al intentar resetar las categorias del combo.");
		}
	}

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/

	/*=======================================================================
	 *
	 * Obtener platos
	 *
	=======================================================================*/
	public function getPlatos($idCategoria = FALSE)
	{
		if($idCategoria !== FALSE) {
			$idCategoria = (int) $idCategoria;
			$query = "SELECT * FROM combos_platos A, platos B WHERE A.idPlato = B.idPlato AND A.idCombo = '{$this->id}' AND B.idCategoria = '{$idCategoria}' ORDER BY B.nombre ASC";
		} else {
			$query = "SELECT * FROM combos_platos WHERE idCombo = '{$this->id}'";
		}

		
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}

	/*=======================================================================
	 *
	 *	Agregar plato
	 *
	=======================================================================*/
	public function addPlato($idPlato)
	{
		$idComboPlato = Conexion::getMysql()->NextID("combos_platos", "idComboPlato");
		$idCombo = (int) $this->id;
		$idPlato = (int) $idPlato;
		$aux_1 = "";
		$aux_2 = "";
		$aux_3 = "";
		$fecha_registro = Time::get();

		$query = "INSERT INTO combos_platos (idComboPlato, idCombo, idPlato, aux_1, aux_2, aux_3, fecha_registro) VALUES ('{$idComboPlato}', '{$idCombo}', '{$idPlato}', '{$aux_1}', '{$aux_2}', '{$aux_3}', '{$fecha_registro}')";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Error al intentar agregar un plato al combo.");
		}
	}

	/*=======================================================================
	 *
	 *	Reset platos
	 *
	=======================================================================*/
	public function resetPlatos()
	{
		$query = "DELETE FROM combos_platos WHERE idCombo = '{$this->id}'";
		$respuesta = Conexion::getMysql()->Ejecutar($query);
		if($respuesta === FALSE) {
			throw new Exception("Error al intentar resetar los platos del combo.");
		}
	}
}