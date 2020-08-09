<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador de ROLES
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
            Incluir::Template("modelo_admin");
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
    public function nuevo($parametros = [])
    {
        if(!isset( $parametros[0] )) {
            $this->Error("No se ha enviado el resturant.");
            return;
        }

        try
        {
            $idRestaurant = $parametros[0];
            $objRestaurant = new RestaurantModel( $idRestaurant );
        }
        catch(Exception $e)
        {
            $this->Error("El restaurant solicitado no existe.");
            return;
        }

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
            $this->Error("No se ha enviado el identificadopr del usuario.");
            return;
        }

        try
        {
            $idUsuario = $parametros[0];
            $objUsuario = new UsuarioModel( $idUsuario );
            $objRestaurant = new RestaurantModel( $objUsuario->getIdRestaurant() );
        }
        catch(Exception $e)
        {
            $this->Error("El usuario <b>{$usuario}</b> solicitado no existe.");
            return;
        }

        $this->Vista("usuarios/ver", [ "objUsuario" => $objUsuario, "objRestaurant" => $objRestaurant ]);
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