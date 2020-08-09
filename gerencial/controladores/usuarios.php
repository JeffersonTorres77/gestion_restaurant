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

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("modelo_gerencial");
            Template::Iniciar();
        }
    }
    
    /*============================================================================
	 *
	 *	Destructor
	 *
    ============================================================================*/
    public function __destruct()
    {
        if(!Peticion::getEsAjax()) {
            Template::Finalizar();
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function index()
    {
        $this->Vista("usuarios/index");
        $this->Javascript("usuarios/index");
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function nuevo()
    {
        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("usuarios/nuevo", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("usuarios/nuevo");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function ver($parametros = [])
    {
        if(!isset( $parametros[0] )) {
            $this->Error("No se ha enviado el identificador del usuario.");
            return;
        }

        try
        {
            $idUsuario = $parametros[0];
            $objUsuario = new UsuarioModel( $idUsuario );
            $objRestaurant = Sesion::getRestaurant();
        }
        catch(Exception $e)
        {
            $this->Error("El usuario <b>{$idUsuario}</b> solicitado no existe.");
            return;
        }

        if($objRestaurant->getId() != $objUsuario->getIdRestaurant()) {
            $this->Error("El usuario <b>{$objUsuario->getNombre()}</b> no pertece al restaurant <b>{$objRestaurant->getNombre()}</b>.");
            return;
        }

        $this->Vista("usuarios/ver", [ "objRestaurant" => $objRestaurant, "objUsuario" => $objUsuario ]);
        $this->Javascript("usuarios/ver");
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("usuarios/crud");
    }
}