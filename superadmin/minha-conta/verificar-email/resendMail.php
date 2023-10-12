<?php 

	$page_name = "Minha Conta";

	require "../../../config/conn.php";
	require "../../../config/geral.php";

	require '../../../vendor/autoload.php';

	echo '<script>window.location.href="../?sendMail=success";</script>';

	// use PHPMailer\PHPMailer\PHPMailer;
	// use PHPMailer\PHPMailer\SMTP;
	// use PHPMailer\PHPMailer\Exception;

	// $body = file_get_contents('../../app/mails/verify_email.php');

	// $mail = new PHPMailer(true);

	// try {

	//     $mail->isSMTP();
	//     $mail->Host       = $config['smtp_host'];
	//     $mail->SMTPAuth   = true;
	//     $mail->Username   = $config['smtp_user'];
	//     $mail->Password   = $config['smtp_pass'];
	//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	//     $mail->Port       = $config['smtp_port'];

	//     $mail->setFrom($config['smtp_user'], $config['app_name']);
	//     $mail->addAddress($user['email'], $user['nome']);

	//     $mail->isHTML(true);
	//     $mail->Subject = utf8_decode($config['app_name'] . ': Confirme seu endereço de e-mail para ativar sua conta');

	//     ob_start();
	//     include('../../app/mails/verify_email.php');
	//     $body = ob_get_clean();

	//     $mail->Body = $body;

	//     $mail->send();

	    

	// } catch (Exception $e) {

	//     echo '<script>alert("Erro: #d89s02d9 | Contacte o suporte!"); window.location.href="../";</script>';

	// }

?>