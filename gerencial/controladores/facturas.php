<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del FACTURAS
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

        if(!MenusAModel::Verificar(6, Sesion::getUsuario()->getRol()->getId())) {
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
    public function hoy()
    {
        if(!MenusBModel::Verificar(4, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $this->Vista("facturas/hoy");
        $this->Javascript("facturas/hoy");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function general()
    {
        if(!MenusBModel::Verificar(5, Sesion::getUsuario()->getRol()->getId())) {
            $this->Error("No tiene permisos para acceder a esta sección.");
            exit;
        }

        $this->Vista("facturas/general");
        $this->Javascript("facturas/general");
    }
    
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("facturas/crud");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function ver($parametros = [])
    {
        if(!isset($parametros[0])) {
            $this->Error('No se ha enviado el identificador de la factura.');
            return;
        }

        $idFactura = $parametros[0];

        try {
            $objFactura = new FacturaModel($idFactura);
        } catch(Exception $e) {
            $this->Error("El identificador de factura <b>{$idFactura}</b> no existe.");
            return;
        }

        $this->Vista("facturas/ver", ['objFactura' => $objFactura]);
        $this->Javascript("facturas/ver");
    }
}