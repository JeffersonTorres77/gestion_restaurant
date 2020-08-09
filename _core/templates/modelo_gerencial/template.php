<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Template MODELO GERENCIAL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Template
{
	/*============================================================================
	 *
	 *	Iniciar
	 *
	============================================================================*/
    public static function Iniciar()
    {
        ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <title><?php echo SISTEMA_NOMBRE; ?></title>
                <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
                <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/font-awesome/css/all.css"; ?>">
                <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>

                <link rel="stylesheet" href="<?php echo HOST."recursos/gerencial/css/template.css"; ?>">
                <script defer src="<?php echo HOST."recursos/gerencial/js/template.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/core/css/core.css"; ?>">
                <script src="<?php echo HOST."recursos/core/js/core.js"; ?>"></script>

                <script>
                    <?php
                        echo 'const HOST = "'.HOST.'";';
                        echo 'const HOST_AJAX = "'.HOST_AJAX.'";';
                        echo 'const HOST_ADMIN = "'.HOST_ADMIN.'";';
                        echo 'const HOST_ADMIN_AJAX = "'.HOST_ADMIN_AJAX.'";';
                        echo 'const HOST_GERENCIAL = "'.HOST_GERENCIAL.'";';
                        echo 'const HOST_GERENCIAL_AJAX = "'.HOST_GERENCIAL_AJAX.'";';

                        echo 'const WEBSOCKET_URL = "'.WEBSOCKET_URL.'";';
                        
                        echo 'const AREA_ADMIN = "'.AREA_ADMIN.'";';
                        echo 'const AREA_GERENCIAL = "'.AREA_GERENCIAL.'";';

                        echo 'const KEY = "'.Sesion::getKey().'";';
                        
                        if(AUDITORIA) echo 'const AUDITORIA = true;';
                        else echo 'const AUDITORIA = false;';
                    ?>
                </script>
            </head>

            <body class="sb-nav-fixed">

                <div class="header sb-topnav navbar navbar-expand navbar-dark">
                    <?php require_once("encabezado.php"); ?>
                </div>

                <div id="layoutSidenav">
                    <?php require_once("menu_lateral.php"); ?>

                    <div id="layoutSidenav_content">
                        <main class="bg-light h-100 overflow-auto">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb p-2 border-bottom" style="border-radius: 0px;">
                                    <?php
                                        $migasPan = [
                                            Peticion::getControlador(),
                                            Peticion::getMetodo()
                                        ];

                                        for($I=0; $I<sizeof($migasPan); $I++)
                                        {
                                            $valor = $migasPan[$I];
                                            $valor = str_replace("_", " ", $valor);
                                            $valor = ucfirst($valor);

                                            if($I == sizeof($migasPan) - 1) {
                                                echo "<li class=\"breadcrumb-item active\">{$valor}</li>";
                                            } else {
                                                echo "<li class=\"breadcrumb-item\">{$valor}</li>";
                                            }
                                        }
                                    ?>
                                </ol>
                            </nav>
        <?php
    }

	/*============================================================================
	 *
	 *	Finalizar
	 *
	============================================================================*/
    public static function Finalizar()
    {
        ?>
                        </main>
                    </div>
                </div>

            </body>
            </html>
        <?php
    }
}