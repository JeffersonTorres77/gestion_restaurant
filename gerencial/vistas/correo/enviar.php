<?php

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$correo = Input::POST("correo", TRUE);

$objUsuario = UsuariosModel::BuscarPorCorreo($correo);
$objRestaurant = new RestaurantModel( $objUsuario->getIdRestaurant() );

// Constantes
$fromemail = "jefersonugas@gmail.com";
$pass = "Jts08112013.";
$fromname = "Sistema Restaurant";
$host = "smtp.gmail.com";
$port = "465";
$SMTPAuth = TRUE;
$SMTPSecure = "ssl";

// Incluir librerias
include_once(BASE_DIR . "_core\APIs\Mailer\src\PHPMailer.php");
include_once(BASE_DIR . "_core\APIs\Mailer\src\SMTP.php");
include_once(BASE_DIR . "_core\APIs\Mailer\src\Exception.php");

// Preparar el mensaje
$emailTo = $correo;
$subjet	= "Credenciales";
$bodyEmail = "Hello world";

// Enviar mensaje
try
{
	$mail = new PHPMailer\PHPMailer\PHPMailer;
	//$mail -> isSMTP();
	$mail ->SMPTDebug = 0;
	$mail ->Host = $host ;
	$mail ->Port= $port;
	$mail ->SMTPAuth= $SMTPAuth;
	$mail ->SMTPSecure= $SMTPSecure;
	$mail ->Username = $fromemail;
	$mail ->Password = $pass;
	$mail ->setFrom($fromemail,$fromname);
	$mail ->addAddress($emailTo);

	//ASUNTO

	$mail ->isHTML(true);
	$mail ->Subject = $subjet;

	// CUERPO DEL EMAIL
	$mail->AddEmbeddedImage("logo.png", "my-attach","logo.png");

	/*$mail->Body = '<img alt="phpMailer" src="cid:my-attach">
	<br><br>
	<b>Usted a solicitado recuperar sus Credenciales:</b>
	<br><br>
	Id Restaurant: '.$objRestaurant->getId().'
	<br><br>
	Usuario: '.$objUsuario->getUsuario().'
	<br><br>
	Clave: ' . $objUsuario->getClave();*/

	$mail->Body ='<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		body{margin:150px;};
	</style>
	<style>
		footer{font-family: sans-serif; font-size: 20px; font-weight: 400; color: #000000; background:#B4B2B2};
	</style>

</head>
<body>
	<img alt="phpMailer" src="cid:my-attach"
	
	<br>
	<br>
	

	<div style="font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #ffffff; font-size: 22px; font-weight: 400; text-align: center; background: #889ccf;margin: 0 0 25px; overflow: hidden; padding: 20px; border-radius: 35px 0px 35px 0px; -moz-border-radius: 35px 0px 35px 0px; -webkit-border-radius: 35px 0px 35px 0px; border: 2px solid #5878ca;"> '.$objUsuario->getnombre().' </div>
	<div align="center">
		<h2 style="font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5878ca; font-size: 34px;">Sistema de Restauante</h2>
		<h2 style="font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5878ca; font-size: 34px;">Informa</h2>
	</div>

	<br>
	<br>
	<div align="left	">
		<h2 style="font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5f5f5f; font-size: 20px;">!Estamos contigo!</h2>	
	</div>

	<div>
		
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5f5f5f; font-size: 20px;">Continuando con atencion acostumbrada a nuestros Socios, Clientes y Colaboradores. Nos complace informarle que nuestro Sistema automatizado de Restablecimiento de Credenciales ha recibido una peticion de consulta a nuestra Bases de Datos. Solicitando la informacion de sus Credenciales para el Ingreso a nuestro Sistema. Despues de verificar y validar la peticion nos complace poder ayudarlo para la continuidad de su uso, A continuacion sus credenciales...
		</p>
	</div>
	<br>
	<div>
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; color: #5f5f5f; font-size: 20px; "> 
			Id Restaurant: <b>'.$objRestaurant->getId().'</b>
		</p>
	</div>
	<div>
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; color: #5f5f5f; font-size: 20px; "> 
			Usuario: <b>'.$objUsuario->getUsuario().'</b>
		</p>
	</div>
	<div>
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; color: #5f5f5f; font-size: 20px; "> 
			Clave: <b>'.$objUsuario->getClave().'</b>
		</p>
	</div>
	<br>
	<div>
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5f5f5f; font-size: 20px;">Le recordamos muy cordialmente la importancia de mantener la confidencialidad  y seguridad de sus Datos, de esta forma contribuimos a la Seguridad de la Informacion y el optimo uso y funcionamiento del Sistema de Restaurant, brindandole la Calidad que Usted merece.
		</p>
	</div>

	<br>
	<br>
	<br>

	<div>
		
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5f5f5f; font-size: 20px;">Atentamente. 
		</p>
		<p style="text-align: justify; font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
				color: #5f5f5f; font-size: 20px;">Administrador del Sistema. 
		</p>
	</div>	
	<br>
	<br>	
</body>
<footer>
	
	<div>
		<p>
			- No responda o reenvie correos a esta cuenta. Esta es una cuenta no monitoreada ni supervisada.
		</p>
		<p>
			- Dispone del siguiente correo en caso de que requieras reportar cualquier situacion irregular: atclient@Sistemaderestaurant.com
		</p>
		
	</div>
</footer>
</html>';

	if (!$mail->send()) {
		throw new Exception($mail->ErrorInfo);
		throw new Exception("No se ha podido enviar la solicitud para recuperar las credenciales al Correo solicitado. Por favor Revise");
	}
}
catch(Exception $e)
{
	throw new Exception($e->getMessage());
}