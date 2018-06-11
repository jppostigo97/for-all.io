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
	$mail->Subject = $emailConfig["title"];

	$email_template = "templates/mail/" . $emailConfig["template"] . ".php";

	ob_start();

	require_once $email_template;
	$mail->Body = ob_get_contents();

	ob_end_clean();

	$mail->AddAddress($emailConfig["target"]);

	if (!$mail->Send())
		$mailError = "No se ha podido enviar el correo electrónico de confirmación.";
	else
		$mailError = "";
?>
