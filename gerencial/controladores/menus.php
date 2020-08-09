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
        if(!isset($parametros[0])) { $this->Error("No se ha enviado el ID del combo."); return; }
        $idCombo = $parametros[0];
        try { $objCombo = new ComboModel( $idCombo ); } catch(Exception $e) { $this->Error("ID del combo [{$idCombo}] invalido."); return; }
        
        $this->Vista("menus/ver", ["objCombo" => $objCombo]);
        $this->Javascript("menus/ver");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function registrar()
    {
        $this->Vista("menus/registrar");
        $this->Javascript("menus/registrar");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function modificar($parametros = [])
    {
        if(!isset($parametros[0])) { $this->Error("No se ha enviado el ID del combo."); return; }
        $idCombo = $parametros[0];
        try { $objCombo = new ComboModel( $idCombo ); } catch(Exception $e) { $this->Error("ID del combo [{$idCombo}] invalido."); return; }

        $categorias = $objCombo->getCategorias();
        $platos = $objCombo->getPlatos();
        
        $arrayCategorias = [];
        $arrayPlatos = [];

        foreach($categorias as $categoria)
        {
            array_push($arrayCategorias, [
                "id" => $categoria['idCategoria'],
                "cantidad" => $categoria['cantidad']
            ]);
        }

        foreach($platos as $plato)
        {
            $objPlato = new PlatoModel( $plato['idPlato'] );

            array_push($arrayPlatos, [
                "id" => $objPlato->getId(),
                "nombre" => $objPlato->getNombre()
            ]);
        }

        $this->Vista("menus/modificar", ["objCombo" => $objCombo]);
        $this->Javascript("menus/modificar");

        ?>
            <script>
                categorias = JSON.parse('<?php echo json_encode($arrayCategorias); ?>');
                platos = JSON.parse('<?php echo json_encode($arrayPlatos); ?>');
            </script>
        <?php
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("menus/crud");
    }
}