<?php 

	require "../../../../config/conn.php";
	require "../../../../config/geral.php";
	require "../../../../config/cdn.php";
	require "../../../app/producer_vars.php";
	require "../../../../vendor/autoload.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$nome = $_GET['nome'];
	$email = $_GET['email'];

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
	    $mail->addAddress($email, $nome);

	    $mail->isHTML(true);
	    $mail->Subject = utf8_decode('Não Responda: ' . $nome . ', seja bem vindo(a) ao ' . $config['app_name'] . '!');
	    $mail->Body = 'Para acessar a plataforma, complete o seu cadastro acessando este <a href="'.$config["app_local"].'/produtor/pre-cadastro/?hs='.md5($email).'">link</a>. <br><br>Ou copie e cole em seu navegador: '.$config["app_local"].'/produtor/pre-cadastro/?hs='.md5($email);

	    $mail->send();
	    echo '<script>window.location.href="../"</script>';
	    
	} catch (Exception $e) { 
		echo '<script>window.location.href="../"</script>';
	}

?>