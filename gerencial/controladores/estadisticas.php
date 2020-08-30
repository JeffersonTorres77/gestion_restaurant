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
    public function por_platillos()
    {
        if(!MenusBModel::Verificar(6, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/por_platillos");
        $this->Javascript("estadisticas/por_platillos");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function por_menus()
    {
        if(!MenusBModel::Verificar(10, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/por_menus");
        $this->Javascript("estadisticas/por_menus");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function por_categorias()
    {
        if(!MenusBModel::Verificar(11, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/por_categorias");
        $this->Javascript("estadisticas/por_categorias");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function por_areas()
    {
        if(!MenusBModel::Verificar(12, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/por_areas");
        $this->Javascript("estadisticas/por_areas");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function por_mesas()
    {
        if(!MenusBModel::Verificar(13, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }
        
        $this->Vista("estadisticas/por_mesas");
        $this->Javascript("estadisticas/por_mesas");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function consultas()
    {
        $this->AJAX('estadisticas/consultas');
    }
}