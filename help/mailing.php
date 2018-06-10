<?php

	require_once "PHPMailer/src/PHPMailer.php";
	require_once "PHPMailer/src/SMTP.php";
	require_once "PHPMailer/src/Exception.php";

	$mail = new PHPMailer\PHPMailer\PHPMailer();

	//$mail->SMTPDebug = 2;

	$mail->isSMTP();
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = "ssl";

	$mail->Host = "smtp.gmail.com";
	$mail->Port = "465";

	$mail->Username = "noreply.forall.io@gmail.com";
	$mail->Password = "abcforall123";

	$mail->SetFrom("noreply.forall.io@gmail.com");

	$mail->isHTML(true);
	$mail->Subject = isset($_POST["email_title"])? $_POST["email_title"] : "Confirma tu cuenta - ForAll.io";

	$email_template = "templates/mail/";
	if (isset($_POST["email_template"])) $email_template .= $_POST["email_template"];
	else $email_template .= "confirm";
	$email_template .= ".php";

	ob_start();

	require_once $email_template;
	$mail->Body = ob_get_contents();

	ob_end_clean();

	$mail->AddAddress(isset($_POST["reg_email"])? $_POST["reg_email"] : "");

	if (!$mail->Send())
		$mailError = "No se ha podido enviar el correo electrónico de confirmación.";
	else
		$mailError = "";
?>
