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

        if(!MenusAModel::Verificar(5, Sesion::getUsuario()->getRol()->getId())) {
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
    public function index()
    {
        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("para_llevar/index", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("para_llevar/index");
    }

    public function menus($parametros = [])
    {
        if(isset($parametros[0]))
        {
            $idMenu = (int) $parametros[0];
            try {
                $objCombo = new ComboModel($idMenu);
            } catch(Exception $e) {
                $this->Error("Menu no encontrado.");
                return;
            }
            
            $objRestaurant = Sesion::getRestaurant();
            $this->Vista("para_llevar/menus_ver", [ "objRestaurant" => $objRestaurant, "objCombo" => $objCombo ]);
            $this->Javascript("para_llevar/menus_ver");
        }
        else
        {
            $objRestaurant = Sesion::getRestaurant();
            $this->Vista("para_llevar/menus", [ "objRestaurant" => $objRestaurant ]);
            $this->Javascript("para_llevar/menus");
        }
    }

    public function carta()
    {
        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("para_llevar/carta", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("para_llevar/carta");
    }

    public function espera()
    {
        $objRestaurant = Sesion::getRestaurant();
        $this->Vista("para_llevar/espera", [ "objRestaurant" => $objRestaurant ]);
        $this->Javascript("para_llevar/espera");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("para_llevar/crud");
    }
}