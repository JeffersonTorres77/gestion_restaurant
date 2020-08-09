<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del COMANDA
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
            Incluir::Template("modelo_cliente");
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
        $this->Vista("carta/index");
        $this->Javascript("carta/index");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function consultar()
    {
        $this->AJAX("carta/consultar");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function pedidos()
    {
        $this->AJAX("carta/pedidos");
    }
}