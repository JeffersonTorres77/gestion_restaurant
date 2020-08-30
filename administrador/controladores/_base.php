<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador base
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class ControladorBase
{
    /*============================================================================
	 *
	 *	Incluir vista
	 *
    ============================================================================*/
    protected function Vista($nombre, $parametros = [])
    {
        $ruta = BASE_DIR . "administrador/vistas/{$nombre}.php";
        if( !(file_exists($ruta) && is_file($ruta)) )
        {
            throw new Exception("Vista <b>{$nombre}</b> no existe.");
        }

        foreach($parametros as $key => $value)
        {
            $$key = $value;
        }

        require_once($ruta);
    }

    /*============================================================================
	 *
	 *	AJAX
	 *
    ============================================================================*/
    protected function AJAX($nombre)
    {
        $ruta = BASE_DIR . "administrador/vistas/{$nombre}.php";
        if( !(file_exists($ruta) && is_file($ruta)) )
        {
            throw new Exception("Vista <b>{$nombre}</b> no existe.");
        }

        if(!Peticion::getEsAjax())
        {
            throw new Exception("Es necesario enviar una solicitud AJAX para acceder a esta sección.");
        }

        $respuesta = [
            "error" =>
            [
                "status" => FALSE,
                "mensaje" => "..."
            ],
            "cuerpo" => []
        ];

        require_once($ruta);
        echo json_encode($respuesta);
    }

    /*============================================================================
	 *
	 *	Incluir Javascript
	 *
    ============================================================================*/
    protected function Javascript($nombre)
    {
        $url = HOST."recursos/administrador/js/{$nombre}.js";
        echo '<script src="'.$url.'?v='.SISTEMA_VERSION.'"></script>';
    }
    
    /*============================================================================
	 *
	 *	Incluir CSS
	 *
    ============================================================================*/
    protected function CSS($nombre)
    {
        $url = HOST."recursos/administrador/css/{$nombre}.css";
        echo '<link rel="stylesheet" href="'.$url.'?v='.SISTEMA_VERSION.'">';
    }

    /*============================================================================
	 *
	 *	Validar Sesión
	 *
    ============================================================================*/
    protected function ValidarSesion()
    {
        if( !Sesion::ValidarAdmin() ) {
            if( Peticion::getEsAjax() )
            {
                throw new Exception("Sesión no iniciada.");
            }
            else
            {
                header("location: ".HOST_ADMIN."Login/");
                exit;
            }
        }
    }

    /*============================================================================
	 *
	 *	Error
	 *
    ============================================================================*/
    protected function Error($mensaje)
    {
        ?>
            <div class="m-2 p-2">
                <div class="alert alert-danger">
                    <?php echo $mensaje; ?>
                </div>
            </div>
        <?php
    }
}