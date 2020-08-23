<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del ESTADISTICAS
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

        if(!MenusAModel::Verificar(7, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a este modulo.");
            exit;
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
    public function general()
    {
        if(!MenusBModel::Verificar(6, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/general");
        $this->Javascript("estadisticas/general");
    }
}