<?php

	include("Mailer\scr\PHPMailer.php");
	include("Mailer\scr\SMTP.php");
	include("Mailer\scr\Exeption.php");
	


	try {
		$emailTo = $_Post["Correorecupera"];
		$subjet	= "Recuperación de Credenciales";
		$bodyEmail = $_Post["Mensajerecupera"];

		$fromemail = "edgarloma@hotmail.com";
		$fromname = "Recuperación";
		$host = "smtp.live.com";
		$port = "587";
		$SMTPAuth = "login";
		$SMTPSecure = "tls";
		$pass	= "071270Hotmail";


		$mail = new PHPMailer\PHPMailer\PHPMailer;

		$mail -> isSMTP();
		$mail ->SMPTDebug = 0;
		$mail ->Host = $host ;
		$mail ->Port= $port;
		$mail ->SMTPAuth= $SMTPAuth;
		$mail ->SMTPSecure= $SMTPSecure;
		$mail ->Username = $fromemail;
		$mail ->Password = $pass;
		$mail ->setFrom($fromemail,$fromname);
		$mail ->addAdress($emailTo);

		//ASUNTO

		$mail ->isHTML(true);
		$mail ->Subjet = $subjet;

		// CUERPO DEL EMAIL
		$mail ->Body = $bodyEmail;

		if (!$mail->send()) {
			error_log("Coreo No Enviado");
		}
		/*$mail -> = $this ->;
		$mail -> = $this ->;
		$mail -> = $this ->;*/			

	} catch (Exeption $e) {

	}

?>