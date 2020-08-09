<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Tags por defecto -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Tags personalizadas -->
	<title>Problemas en el sistema</title>
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
			Ha ocurrido un problema en el sistema
		</div>

		<hr>

		<div>
            Comuniquese con el <b>administrador</b> y notifiquele el problema.
		</div>

		<hr>

		<div class="text-left">
			<button class="btn btn-danger" onclick="location.reload()">
				Actualizar
			</button>
		</div>
	</div>
</div>
	
</body>
</html>