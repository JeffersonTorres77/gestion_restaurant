<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	MySQL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class MySQL
{    
    /*========================================================================
	 *
	 *	Atributos
	 *
    ========================================================================*/
    private $servidor;
    private $puerto;
    private $usuario;
    private $clave;
    private $nombre;
    private $conexion;

    /*========================================================================
	 *
	 *	Constructor
	 *
    ========================================================================*/
    public function __construct($servidor, $puerto, $usuario, $clave, $nombre_bd)
    {
        //Guardamos los datos
        $this->servidor = $servidor;
        $this->puerto = $puerto;
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->nombre = $nombre_bd;

        //Conectamos
        $this->conexion = @mysqli_connect(
            $this->servidor,
            $this->usuario,
            $this->clave,
            $this->nombre,
            $this->puerto
        );

        //Verificamos si esta conectado
        if(!$this->conexion)
        {
            throw new Exception("Error al intentar conectar con la base de datos (MySQLi).");
            set_error_handler($gestor_error);
        }

        //Agregamos el diccionario UTF8
        $this->conexion->set_charset("utf8");
        mysqli_set_charset($this->conexion, "utf8");

        //Quitamos el autocommit
 		$this->conexion->autocommit(FALSE);
    }

    /*========================================================================
	 *
	 *	Destructor
	 *
    ========================================================================*/
    public function __destruct()
    {
        //Si no hay conexión salimos
		if(!$this->conexion) return;

        //Desconectamos
        @mysqli_close($this->conexion);
    }

    public function Cerrar()
    {
        //Si no hay conexión salimos
		if(!$this->conexion) return;

        //Desconectamos
        @mysqli_close($this->conexion);
    }

    /*========================================================================
	 *
	 *	Commit
	 *
    ========================================================================*/
    public function Commit()
    {
        //Verificamos que haya conexión
        if(!$this->conexion) {
            throw new Exception("Conectese antes a la base de datos antes de ejecutar el query.");
        }

        $respuesta = $this->conexion->commit();
        if(!$respuesta)
        {
            throw new Exception("Error al intentar hacer commit.");
        }
    }

    /*========================================================================
	 *
	 *	Rollback
	 *
    ========================================================================*/
    public function Rollback()
    {
        //Verificamos que haya conexión
        if(!$this->conexion) {
            throw new Exception("Conectese antes a la base de datos antes de ejecutar el query.");
        }

        $respuesta = $this->conexion->rollback();
        if(!$respuesta)
        {
            throw new Exception("Error al intentar hacer rollback.");
        }
    }

    /*========================================================================
	 *
	 *	Ejecutar
	 *
    ========================================================================*/
    public function Ejecutar($query)
    {
        //Verificamos que haya conexión
        if(!$this->conexion) {
            throw new Exception("Conectese antes a la base de datos antes de ejecutar el query.");
        }

        //Ejecutamos el query
        $resultado = $this->conexion -> query($query);

        //Retornamos el resultado
        return $resultado;
    }

    /*========================================================================
	 *
	 *	Consultar
	 *
    ========================================================================*/
    public function Consultar($query)
    {
        //Verificamos que haya conexión
        if(!$this->conexion) {
            throw new Exception("Conectese antes a la base de datos antes de consultar el query.");
        }

        //Ejecutamos el query
        $resultado = $this->Ejecutar($query);
        if($resultado === FALSE) {
            throw new Exception("Error al realizar la consulta:<br>{$query}");
        }

        //Iniciamos las variables
        $datos = Array();
        $I = 0;

        //Guardamos en el vector
        while($fila = $resultado->fetch_assoc())
        {
            $datos[$I] = $fila;
            $I++;
        }

        //Retornamos
        return $datos;
    }

    /*========================================================================
	 *
	 *	Obtener errores
	 *
    ========================================================================*/
    public function getError()
    {
        //Retornamos el error del MySQL
		return mysqli_error($this->conexion);
    }

    /*========================================================================
	 *
	 *	Proximo ID
	 *
    ========================================================================*/
    public function nextID($tabla, $columna)
    {
        $query = "SELECT MAX({$columna}) as maxID FROM {$tabla}";
        $datos = $this->Consultar($query);

        $maxID = $datos[0]['maxID'];
        if(!isset($maxID) || $maxID == null || $maxID == "") {
            $maxID = 0;
        }

        $nextID = $maxID + 1;
        return $nextID;
    }
}