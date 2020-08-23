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

        if(!MenusAModel::Verificar(5, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a este modulo.");
            exit;
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
    public function pedidos($parametros = [])
    {
        if(!isset($parametros[0])) {
            $this->Error("No se ha especificado el area.");
            return;
        }

        $area = strtolower($parametros[0]);
        echo '<script src="' . HOST."recursos/core/js/socket.io.js" . '"></script>';

        switch($area)
        {
            case "general":
                if(!MenusBModel::Verificar(-2, Sesion::getUsuario()->getRol()->getId())) {
                    $this->Error("No tiene permisos para acceder a esta sección.");
                    exit;
                }

                $this->Vista("monitoreo/general");
                $this->Javascript("monitoreo/general");
            break;
            
            case "cocina":
                if(!MenusBModel::Verificar(-1, Sesion::getUsuario()->getRol()->getId())) {
                    $this->Error("No tiene permisos para acceder a esta sección.");
                    exit;
                }

                $this->Vista("monitoreo/individual", ['idAreaMonitoreo' => 2]);
                $this->Javascript("monitoreo/individual");
            break;
            
            case "bar":
                if(!MenusBModel::Verificar(0, Sesion::getUsuario()->getRol()->getId())) {
                    $this->Error("No tiene permisos para acceder a esta sección.");
                    exit;
                }

                $this->Vista("monitoreo/individual", ['idAreaMonitoreo' => 3]);
                $this->Javascript("monitoreo/individual");
            break;
            
            case "postres":
                if(!MenusBModel::Verificar(1, Sesion::getUsuario()->getRol()->getId())) {
                    $this->Error("No tiene permisos para acceder a esta sección.");
                    exit;
                }

                $this->Vista("monitoreo/individual", ['idAreaMonitoreo' => 4]);
                $this->Javascript("monitoreo/individual");
            break;

            default:
                $this->Error("Area de monitoreo de pedidos invalida.");
                return;
            break;
        }
    }

    /*============================================================================
     *
     *  
     *
    ============================================================================*/
    public function camarero()
    {
        if(!MenusBModel::Verificar(2, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

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
        if(!MenusBModel::Verificar(3, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $this->Vista("monitoreo/caja");
        echo '<script src="' . HOST."recursos/core/js/socket.io.js" . '"></script>';
        $this->Javascript("monitoreo/caja");
    }
}