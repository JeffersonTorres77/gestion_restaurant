<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del GESTION_SISTEMA
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
            Incluir::Template("modelo_admin");
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
    public function usuarios( $parametros = [] )
    {
        if(isset($parametros[0]))
        {
            $usuario = $parametros[0];
            if(!AdminUsuariosModel::Existe($usuario)) {
                $this->Error("EL usuario <b>{$usuario}</b> no existe.");
            }

            $objUsuario = new AdminUsuarioModel($usuario);
            $this->Vista("gestion_sistema/usuarios-ver", [ "objUsuario" => $objUsuario ]);
            $this->Javascript("gestion_sistema/usuarios-ver");
        }
        else
        {
            $this->Vista("gestion_sistema/usuarios");
            $this->Javascript("gestion_sistema/usuarios");
        }
    }

    public function crud_usuarios()
    {
        $this->AJAX("gestion_sistema/crud-usuarios");
    }
}