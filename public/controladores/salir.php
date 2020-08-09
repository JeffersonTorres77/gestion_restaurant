<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del INICIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Controlador extends ControladorBase
{
    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct()
    {
        $this->ValidarSesion();
    }
    
    /*============================================================================
	 *
	 *	Destructor
	 *
    ============================================================================*/
    public function __destruct()
    {
        
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function index()
    {
        $respuesta = [
            "error" =>
            [
                "status" => FALSE,
                "mensaje" => "..."
            ],
            "cuerpo" => []
        ];

        $objMesa = Sesion::getUsuario();
        $clave = Input::POST("clave", TRUE);

        if($objMesa->getClave() != $clave) {
            throw new Exception("Contraseña incorrecta.");
        }
        
        Sesion::CerrarCliente();
        Conexion::getMysql()->Commit();

        if( Peticion::getEsAjax() ) {
            echo json_encode( $respuesta );
        } else {
            header("location: ".HOST."Login/");
        }
    }
}