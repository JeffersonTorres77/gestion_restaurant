<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tags por defecto -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tags personalizadas -->
    <title>Excepción del sistema</title>
    <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
    <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.min.js"; ?>"></script>
    <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
    <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>
</head>
<body>

<div class="p-3">
    <div class="alert alert-warning text-break">
        <div class="font-weight-bold">
            Excepción del sistema
        </div>

        <hr>

        <div>
            Se ha producido una excepción en el archivo:<br>
            <b><?php echo $archivo; ?></b> - linea: <b><?php echo $linea; ?></b>

            <br><br>

            Codigo: <?php echo $codigo; ?>
            <br>
            <?php echo $mensaje; ?>
        </div>

        <?php
            if(sizeof($trazas) > 0)
            {
                ?>
                    <hr>

                    <div>
                        <b>Trazas</b>

                        <br><br>

                        <?php
                            foreach($trazas as $traza)
                            {
                                $file = $traza['file'];
                                $line = $traza['line'];
                                $function = $traza['function'];
                                echo "{$file} [{$line}] - {$function}<br>";
                            }
                        ?>
                    </div>
                <?php
            }
        ?>

        <hr>

        <div class="text-left">
            <button class="btn btn-warning" onclick="location.reload()">
                Actualizar
            </button>
        </div>
    </div>
</div>

</body>
</html>