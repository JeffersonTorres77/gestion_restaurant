<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del COMBOS
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
        $this->Vista("menus/index");
        $this->Javascript("menus/index");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function ver($parametros = [])
    {
        if(!isset($parametros[0])) {
            $msj = 'No se ha enviado el identificador del combo.';
            $msj .= '<br><br>';
            $msj .= '<button class="btn btn-danger" onclick="history.go(-1)">Atras</button>';
            $this->Error($msj);
            return;
        }

        $idCombo = $parametros[0];
        try { $objCombo = new ComboModel($idCombo); } catch(Exception $e) {
            $msj = 'Identificador invalido.';
            $msj .= '<br><br>';
            $msj .= '<button class="btn btn-danger" onclick="history.go(-1)">Atras</button>';
            $this->Error($msj);
            return;
        }

        $objRestaurant = Sesion::getRestaurant();

        if($objCombo->getIdRestaurant() != $objRestaurant->getId()) {
            $msj = 'El combo solicitado no pertenece al restaurant <b>'.$objRestaurant->getNombre().'</b>.';
            $msj .= '<br><br>';
            $msj .= '<button class="btn btn-danger" onclick="history.go(-1)">Atras</button>';
            $this->Error($msj);
            return;
        }

        if(!$objCombo->getActivo()) {
            $msj = 'El combo solicitado no esta activo.';
            $msj .= '<br><br>';
            $msj .= '<button class="btn btn-danger" onclick="history.go(-1)">Atras</button>';
            $this->Error($msj);
            return;
        }

        $this->Vista("menus/ver", ["objRestaurant" => $objRestaurant, "objCombo" => $objCombo]);
        $this->Javascript("menus/ver");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function consultar()
    {
        $this->AJAX("menus/consultar");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function pedidos()
    {
        $this->AJAX("menus/pedidos");
    }
}