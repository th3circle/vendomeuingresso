<?php 


	require "../conn.php"
	require "../geral.php"
	require "../../vendor/autoload.php"

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;


	$mail = new PHPMailer(true);

	try {

	    $mail->isSMTP();
	    $mail->Host       = $config['smtp_host'];
	    $mail->SMTPAuth   = true;
	    $mail->Username   = $config['smtp_user'];
	    $mail->Password   = $config['smtp_pass'];
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	    $mail->Port       = $config['smtp_port'];

	    $mail->setFrom($config['smtp_user'], $config['app_name']);

	    $mail->addAddress('joe@example.net', 'Joe User');

	    $mail->isHTML(true);
	    $mail->Subject = $config['app_name'] . ': Novo Cadastro!';
	    $mail->Body    = 'Novo cadastro no sistema!';
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();

	}


?>