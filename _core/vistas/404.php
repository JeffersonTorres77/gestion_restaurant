<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Tags por defecto -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Tags personalizadas -->
	<title>Pagina no encontrada</title>
    <link rel="shortcut icon" href="<?php echo HOST."recursos/core/img/logotipo.png"; ?>" type="image/png">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="<?php echo HOST."recursos/bootstrap/css/bootstrap.min.css"; ?>">
    <script src="<?php echo HOST."recursos/bootstrap/js/bootstrap.bundle.min.js"; ?>"></script>
    <script src="<?php echo HOST."recursos/jquery/js/jquery.min.js"; ?>"></script>
    <script src="<?php echo HOST."recursos/font-awesome/js/all.js"; ?>"></script>
</head>
<body>

<div class="p-3">
	<div class="alert alert-danger text-break">
		<div class="font-weight-bold">
			Pagina no encontrada
		</div>

		<hr>

		<div>
            <?php
                $pagina = Peticion::getControlador()."/".Peticion::getMetodo();
                echo "La pagina <b>{$pagina}</b> no esta disponible en el sistema.";
            ?>
		</div>

		<hr>

		<div class="text-left">
            <button class="btn btn-danger" onclick="history.go(-1)">
				Atras
			</button>

            <button class="btn btn-danger" onclick="location.href = '<?php echo HOST; ?>'">
				Inicio
			</button>
		</div>
	</div>
</div>
	
</body>
</html>