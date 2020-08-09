<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Template del Login
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Template
{
    /*============================================================================
	 *
	 * Iniciar
	 *
	============================================================================*/
    public static function Iniciar( $title = SISTEMA_NOMBRE )
    {
        ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <title><?php echo $title; ?></title>
                <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
                <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
                <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.js"; ?>"></script>
                <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>
                
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
                        
                        if(AUDITORIA) echo 'const AUDITORIA = true;';
                        else echo 'const AUDITORIA = false;';
                    ?>
                </script>
            </head>
            <body>

            <div class="h-100 v-100 bg-light">
                <div class="w-100 h-100">
                    <div class="d-flex align-items-center justify-content-center h-100">

                        <div class="card p-0 shadow overflow-auto" style="width: 100%; max-width: 400px; max-height: 90%;">
                            <div class="card-header login-titulo">
                                <?php echo $title; ?>
                            </div>

                            <div class="card-body">
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
                            </div>

                            <div class="w-100 bg-light border-top small">
                                <div class="row m-0">
                                    <div class="col-6 text-left p-2">
                                        <a href="<?php echo HOST; ?>">
                                            <i class="fas fa-home"></i>
                                            Inicio
                                        </a>
                                    </div>

                                    <div class="col-6 text-right p-2">
                                        Versión <?php echo SISTEMA_VERSION; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </body>
            </html>
        <?php
    }
}