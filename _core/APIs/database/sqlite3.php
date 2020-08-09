<?php

class SQLite
{
    /*========================================================================
	 *
	 *	Atributos
	 *
    ========================================================================*/
    private $ruta;
    private $conexion;

    /*========================================================================
	 *
	 *	Constructor
	 *
    ========================================================================*/
    public function __construct($ruta)
    {
        //Guardamos los datos
        $this->ruta = $ruta;

        //Conectamos
        $this->conexion = new PDO("sqlite:{$ruta}");

        //Verificamos si esta conectado
        if(!$this->conexion)
        {
            throw new Exception("Error al intentar conectar con la base de datos (SQLite3).");
        }

        //Atributos
        $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        //Iniciamos la transacción
        $this->Begin();
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
        $this->conexion = null;
    }

    public function Cerrar()
    {
        //Si no hay conexión salimos
		if(!$this->conexion) return;

        //Desconectamos
        $this->conexion = null;
    }

    /*========================================================================
	 *
	 *	Begin
	 *
    ========================================================================*/
    public function Begin()
    {
        $query = "BEGIN";
        $this->Ejecutar($query);
    }

    /*========================================================================
	 *
	 *	Rollback
	 *
    ========================================================================*/
    public function Rollback()
    {
        $query = "ROLLBACK";
        $this->Ejecutar($query);
        $this->Begin();
    }

    /*========================================================================
	 *
	 *	Commit
	 *
    ========================================================================*/
    public function Commit()
    {
        $query = "COMMIT";
        $this->Ejecutar($query);
        $this->Begin();
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
        $resultado = $this->conexion->query($query);

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
        $sentencia = $this->conexion->query($query);
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $resultado = $sentencia->execute();
        if($resultado === FALSE) {
            throw new Exception("Error al realizar la consulta:<br>{$query}");
        }

        //Iniciamos las variables
        $datos = Array();
        $I = 0;

        //Guardamos en el vector
        while($fila = $sentencia->fetch())
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
        return $this->conexion->errorInfo()[2];
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