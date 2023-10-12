<?php 

	$page_name = 'Novo Evento';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	$event = $_SESSION['event_data'];

	if (isset($_POST['ingresso'])) {
		$event = array(
			"nome" 			=> $_SESSION['event_data']['nome'],
			"descricao" 	=> $_SESSION['event_data']['descricao'],
			"categoria" 	=> $_SESSION['event_data']['categoria'],
			"capa" 			=> $_SESSION['event_data']['capa'],
			"cep" 			=> $_SESSION['event_data']['cep'],
			"bairro" 		=> $_SESSION['event_data']['bairro'],
			"cidade" 		=> $_SESSION['event_data']['cidade'],
			"estado" 		=> $_SESSION['event_data']['estado'],
			"rua" 			=> $_SESSION['event_data']['rua'],
			"data" 			=> $_SESSION['event_data']['data'],
			"ingressos"		=> $_POST['ingresso'],
		);

		$_SESSION['event_data'] = $event;
	}

	if (isset($_SESSION['user_producer'])) {

    	$id_producer 	= $_SESSION['user_producer']['id'];
		$nome			= $event['nome'];
		$descricao		= $event['descricao'];
		$categoria		= $event['categoria'];
		$capa			= $event['capa'];
		$cep			= $event['cep'];
		$bairro			= $event['bairro'];
		$cidade			= $event['cidade'];
		$estado			= $event['estado'];
		$rua			= $event['rua'];

		$data			= json_encode($event['data']);
		$event_data		= $event['data'][0];

		$ingressos		= json_encode($event['ingressos']);

		$query = "INSERT INTO events (tipo, business_id, banner, title, city, uf, local, description, days, ingressos, event_data)
			  	  VALUES (1, '$id_producer', '$capa', '$nome', '$cidade', '$estado', '$rua', '$descricao', '$data', '$ingressos', '$event_data')";

		if ($conn->query($query) === TRUE) {

			$id_evento = $conn->insert_id;
			header('Location: ../../produtor/eventos/ver/?id=' . $id_evento);

		} else {
			echo '<script>alert("#3192ND76SS | Erro ao executar a ação! Contacte o suporte.");</script>';
		}

	}

	if (isset($_POST['register'])) {

		$user_pass 			= $_POST['user_pass'];
		$user_repass 		= $_POST['user_repass'];

		if ($user_pass == $user_repass) {

			$user_nome 			= $_POST['user_nome'];
			$user_sobrenome 	= $_POST['user_sobrenome'];
			$user_email 		= $_POST['user_email'];
			$user_cpfcnpj 		= $_POST['user_cpfcnpj'];
			$user_passHash		= hash('sha256', $_POST['user_pass']);

			$query = "INSERT INTO producer (name, surname, email, cpf_cnpj, senha)
					  VALUES ('$user_nome', '$user_sobrenome', '$user_email', '$user_cpfcnpj', '$user_passHash')";

		    if ($conn->query($query) === TRUE) {

		    	$id_producer 	= $conn->insert_id;
				$nome			= $event['nome'];
				$descricao		= $event['descricao'];
				$categoria		= $event['categoria'];
				$capa			= $event['capa'];
				$cep			= $event['cep'];
				$bairro			= $event['bairro'];
				$cidade			= $event['cidade'];
				$estado			= $event['estado'];
				$rua			= $event['rua'];

				$data			= json_encode($event['data']);
				$event_data		= $event['data'][0];

				$ingressos		= json_encode($event['ingressos']);

				$query = "INSERT INTO events (tipo, business_id, banner, title, city, uf, local, description, days, ingressos, event_data)
					  	  VALUES (1, '$id_producer', '$capa', '$nome', '$cidade', '$estado', '$rua', '$descricao', '$data', '$ingressos', '$event_data')";

				if ($conn->query($query) === TRUE) {

					$_SESSION['user_producer'] = array(
						"id" => $id_producer,
						"nome" => $user_nome,
						"sobrenome" => $user_sobrenome,
						"email" => $user_email,
						"cpf_cnpj" => $user_cpfcnpj,
						"passHash" => $user_passHash,
					);

					$id_evento = $conn->insert_id;
					header('Location: ../../produtor/eventos/ver/?id=' . $id_evento);

				} else {
					echo '<script>alert("#3192ND76 | Erro ao executar a ação! Contacte o suporte.");</script>';
				}

		    } else {
		        echo '<script>alert("#8193NLD0 | Erro ao executar a ação! Contacte o suporte.");</script>';
		    }
			
		} else { $error_message = "As senhas não conferem."; }
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/login.css">
</head>
<body>
	<div class="align">
		<div class="container">
			<div class="row">
				<div class="col-11 col-lg-4 mx-auto">

					<div style="border-top: 15px solid var(--secundaria);" id="registerBox" class="login_box">
						<form method="POST" id="registerForm" action="">
							<h2>Cadastrar</h2>
							<p style="width: 100%;">Crie uma conta para publicar o seu evento.</p>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-user align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Nome" type="text" name="user_nome">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-user align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Sobrenome" type="text" name="user_sobrenome">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-passport align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="CPF ou CNPJ" id="cpf_cnpj" oninput="this.value = formatCPF_CNPJ(this.value)" maxlength="18" type="text" name="user_cpfcnpj">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-envelope align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="E-mail" type="email" name="user_email">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui a sua senha" type="password" name="user_pass">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Repita a sua senha" type="password" name="user_repass">
									</div>
								</div>
							</div>
							<button form="registerForm" style="margin-top: 15px; border-radius: 15px;" name="register" class="primario">CADASTRAR</button>
							<p id="fazer-login" class="cadastrar">FAZER LOGIN</p>
							<?php if (isset($error_message)) { echo '<p class="error_message">'.$error_message.'</p>'; } ?>
						</form>
					</div>

					<div style="border-top: 15px solid var(--secundaria); display: none;" id="loginBox" class="login_box">
						<form method="POST" id="loginForm" action="">
							<h2>Faça Login</h2>
							<p style="width: 100%;">Entre para publicar o seu evento.</p>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-envelope align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="E-mail" type="email" name="user_email">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui a sua senha" type="password" name="user_pass">
									</div>
								</div>
							</div>
							<button form="loginForm" style="margin-top: 15px; border-radius: 15px;" name="login" class="primario">ENTRAR</button>
							<p id="cadastrar" class="cadastrar">CADASTRAR</p>
							<?php if (isset($error_message)) { echo '<p class="error_message">'.$error_message.'</p>'; } ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<p class="copy">Desenvolvido com muito &#9749; por <a target="_blank" href="https://thecircle.com.br/">The Circle</a></p>
</body>
<script>

const fazerLoginButton = document.getElementById('fazer-login');
const registerButton = document.getElementById('cadastrar');

const loginBox = document.getElementById('loginBox');
const registerBox = document.getElementById('registerBox');

fazerLoginButton.addEventListener('click', function() {
    loginBox.style.display = 'block';
    registerBox.style.display = 'none';
});

registerButton.addEventListener('click', function() {
    loginBox.style.display = 'none';
    registerBox.style.display = 'block';
});

</script>
<script>
function formatCPF_CNPJ(input) {
    const cleanInput = input.replace(/\D/g, '');

    if (cleanInput.length === 11) { // CPF
        return cleanInput.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (cleanInput.length === 14) { // CNPJ
        return cleanInput.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }

    return input;
}
</script>
</html>