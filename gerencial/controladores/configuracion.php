<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del CONFIGURACION
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

        if(!MenusAModel::Verificar(10, Sesion::getUsuario()->getRol()->getId())) {
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
    public function administracion()
    {
        if(!MenusBModel::Verificar(7, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("configuracion/administracion", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("configuracion/administracion");
    }

    public function datos()
    {
        if(!MenusBModel::Verificar(8, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("configuracion/datos", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("configuracion/datos");
    }

    public function redes_sociales()
    {
        if(!MenusBModel::Verificar(9, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("configuracion/redessociales", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("configuracion/redessociales");
    }

    public function servicio()
    {
        if(!MenusBModel::Verificar(14, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("configuracion/servicio", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("configuracion/servicio");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud_restaurantes()
    {
        $this->AJAX("configuracion/crud_restaurantes");
    }
}