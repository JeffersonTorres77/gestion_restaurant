<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Controlador del INICIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Controlador extends ControladorBase
{
    /*============================================================================
     *
     *  Constructor
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
     *  Destructor
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
    public function cocina()
    {
        $this->Vista("monitoreo/cocina");
        echo '<script src="' . HOST."recursos/core/js/socket.io.js" . '"></script>';
        $this->Javascript("monitoreo/cocina");
    }

    /*============================================================================
     *
     *  
     *
    ============================================================================*/
    public function camarero()
    {
        $this->Vista("monitoreo/camarero");
        echo '<script src="' . HOST."recursos/core/js/socket.io.js" . '"></script>';
        $this->Javascript("monitoreo/camarero");
    }

    /*============================================================================
     *
     *  
     *
    ============================================================================*/
    public function caja()
    {
        $this->Vista("monitoreo/caja");
        echo '<script src="' . HOST."recursos/core/js/socket.io.js" . '"></script>';
        $this->Javascript("monitoreo/caja");
    }
}