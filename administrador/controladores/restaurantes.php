<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador de RESTURANTES
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
    public function gestion($parametros = [])
    {
        if(isset($parametros[0]))
        {
            $idRestaurante = $parametros[0];

            try {
                $objRestaurant = new RestaurantModel($idRestaurante);
            } catch(Exception $e) {
                $this->Error("Restaurant <b>ID: {$idRestaurante}</b> invalido.");
                return;
            }

            //VER RESTAURANTE
            $this->Vista("restaurantes/ver", [ "objRestaurant" => $objRestaurant ]);
            $this->Javascript("restaurantes/ver");
        }
        else
        {
            //TABLA DE GESTION
            $this->Vista("restaurantes/gestion");
            $this->Javascript("restaurantes/gestion");
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function registrar()
    {
        $this->Vista("restaurantes/registrar");
        $this->Javascript("restaurantes/registrar");
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("restaurantes/crud");
    }
}