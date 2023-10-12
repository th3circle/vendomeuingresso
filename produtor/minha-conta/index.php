<?php 

	$page_name = "Minha Conta";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";
	require "../app/producer_vars.php";

	if (!isset($_SESSION['user_producer'])) { header('Location: '.$config["app_local"].'/produtor'); }

	$id = $producer['id'];

	if (isset($_GET['sendMail'])) {
		$cor = "#4baf00";
		$msg = "E-mail enviado com sucesso! Acesse através de um aparelho logado e confirme a sua conta!";
	}

	if (isset($_POST['senha']) AND !empty($_POST['senha'])) {

		$senha = hash('sha256', $_POST['senha']);
		$query = "UPDATE producer SET senha = '$senha' WHERE id = '$id'";
	    if ($conn->query($query) === TRUE) { session_destroy(); echo '<script>window.location.href="./";</script>'; }

	}

	if (isset($_POST['name'])) {

		$name 						= $_POST['name'];
		$surname 					= $_POST['surname'];
		$telefone 					= $_POST['telefone'];
		$email 						= $_POST['email'];
		$endereco_cep 				= $_POST['endereco_cep'];
		$endereco_cidade 			= $_POST['endereco_cidade'];
		$endereco_estado 			= $_POST['endereco_estado'];
		$endereco_longradouro 		= $_POST['endereco_longradouro'];
		$cpf_cnpj 					= $_POST['cpf_cnpj'];
		$email_fiscal 				= $_POST['email_fiscal'];

		$query = "UPDATE producer SET name = '$name', surname = '$surname', telefone = '$telefone', email = '$email', endereco_cep = '$endereco_cep', endereco_cidade = '$endereco_cidade', endereco_estado = '$endereco_estado', endereco_longradouro = '$endereco_longradouro', cpf_cnpj = '$cpf_cnpj', email_fiscal = '$email_fiscal' WHERE id = '$id'";
	    if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

	}

	if (isset($_FILES['pp'])) {

		$pp = $_FILES['pp']['tmp_name'];
		$destination = '../attachments/pp/' . $id . '.jpg';
		if (move_uploaded_file($pp, $destination)) {

			$newName = $id . '.jpg';
			$query = "UPDATE producer SET pp = '$newName' WHERE id = '$id'";
			if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/financeiro.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/minha-conta.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body>
	<?php require "../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div style="margin-top: 20px;" class="row">
			<div class="col-3">
				<div class="module profile_pp" style="background: url('../attachments/pp/<?php
				    if (empty($producer['pp'])) {
				        echo 'no-picture.jpg';
				    } else {
				        echo $producer['pp'];
				    }
				?>');"></div>
				<span id="clickUpdate"><i class="fa-regular fa-pen-to-square changePic"></i></span>
				<form action="" method="POST" enctype="multipart/form-data" id="formPP">
					<input type="file" name="pp" id="inputPP" style="display: none;">
				</form>
				<ul class="left_menu">
					<a href="#"><li class="ative">Minha Conta</li></a>
					<a href="../app/logout.php"><li>Sair</li></a>
				</ul>
			</div>
			<div class="col-9">
				<?php if ($producer['verify_email'] == false) { ?>
				<div <?php if (isset($cor)) { echo 'style="background: '.$cor.' !important;"'; } ?> class="alert_email">
					<div class="row">
						<div class="col-10">
							<div style="font-size: 0.8rem !important;" class="align">
								<i class="fa-solid fa-bell"></i>
								<?php 

								if (isset($msg)) {
									echo $msg;
								} else {
									echo 'Atenção! Verifique o seu e-mail para concluir o processo de confirmação.';
								}

								?>
							</div>
						</div>
						<div style="text-align: right;" class="col-2">
							<div class="align">
								<button <?php if (isset($_GET['sendMail'])) { echo 'style="opacity: 0 !Important; cursor: defaut !Important;"'; } else { echo 'onclick="window.location.href=`./verificar-email/resendMail.php`"'; } ?> class="resend">
									<i class="fa-regular fa-share-from-square"></i>
									Reenviar
								</button>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="module">
					<form method="POST" action="#" id="updateProfile">
						<div class="row">
							<div class="col-4">
								<label class="input">Nome: <b class="req">*</b></label>
								<input required value="<?php if(isset($producer['name'])) {echo $producer['name'];} ?>" type="text" name="name">
							</div>
							<div class="col-4">
								<label class="input">Sobrenome: <b class="req">*</b></label>
								<input required value="<?php if(isset($producer['surname'])) {echo $producer['surname'];} ?>" type="text" name="surname">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-4">
								<label class="input">Telefone:</label>
								<input required value="<?php if(isset($producer['telefone'])) {echo $producer['telefone'];} ?>" id="telefone" type="text" name="telefone">
							</div>
							<div class="col-5">
								<label class="input">E-mail: <b class="req">*</b></label>
								<input required value="<?php if(isset($producer['email'])) {echo $producer['email'];} ?>" type="email" name="email">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-4">
								<label class="input">Alterar Senha:</label>
								<input onclick="value=''" id="input_pass" minlength="8" type="password" name="nova_senha">
							</div>
							<div class="col-2">
								<button style="padding: 10px 15px !important; margin-top: 8px;" type="button" id="buttonUpdatePass" class="act_money">Alterar</button>
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-2">
								<label class="input">CEP: <b class="req">*</b></label>
								<input required onkeyup="buscaCEP()" value="<?php if(isset($producer['endereco_cep'])) {echo $producer['endereco_cep'];} ?>" type="text" id="cep" name="endereco_cep">
							</div>
							<div class="col-3">
								<label class="input">Cidade: <b class="req">*</b></label>
								<input required <?php if(isset($producer['endereco_cidade'])) {echo 'value="' . $producer['endereco_cidade'] . '"';} ?> type="text" id="cidade" name="endereco_cidade">
							</div>
							<div class="col-3">
								<label class="input">Estado: <b class="req">*</b></label>
								<input required <?php if(isset($producer['endereco_estado'])) {echo 'value="' . $producer['endereco_estado'] . '"';} ?> type="text" id="estado" name="endereco_estado">
							</div>
							<div class="col-4">
								<label class="input">Endereço: <b class="req">*</b></label>
								<input required <?php if(isset($producer['endereco_longradouro'])) {echo 'value="' . $producer['endereco_longradouro'] . '"';} ?> type="text" id="longradouro" name="endereco_longradouro">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-3">
								<label class="input">CPF ou CNPJ: <b class="req">*</b></label>
								<input required value="<?php if(isset($producer['cpf_cnpj'])) {echo $producer['cpf_cnpj'];} ?>" type="text" name="cpf_cnpj">
							</div>
							<div class="col-4">
								<label class="input">E-mail Fiscal: <b class="req">*</b></label>
								<input required value="<?php if(isset($producer['email_fiscal'])) {echo $producer['email_fiscal'];} else { echo $producer['email']; } ?>" type="text" name="email_fiscal">
							</div>
						</div>
					</form>
				</div>
				<div style="margin-top: 20px;" class="row">
					<div style="text-align: right;" class="col-12">
						<div class="acoes align">
							
							<!-- sacar -->
							<button form="updateProfile" class="act_money">
								<i class="fa-solid fa-floppy-disk"></i>
								Salvar
							</button>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<form id="formUpdatePass" method="POST" action="">
	<input required type="hidden" name="senha">
</form>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var buttonUpdatePass = document.getElementById('buttonUpdatePass');
        var inputPass = document.getElementById('input_pass');
        var formUpdatePass = document.getElementById('formUpdatePass');
        var senhaInput = formUpdatePass.querySelector('input[name="senha"]');

        buttonUpdatePass.addEventListener('click', function () {
            // Pega o valor do input #input_pass
            var novaSenha = inputPass.value;

            // Define o valor no input de senha do formulário
            senhaInput.value = novaSenha;

            // Submete o formulário
            formUpdatePass.submit();
        });
    });
</script>
<script>
document.getElementById('clickUpdate').addEventListener('click', function() {
    console.log('Código JavaScript executado');
    document.getElementById('inputPP').click();
});

document.getElementById('inputPP').addEventListener('change', function() {
    document.getElementById('formPP').submit();
});

function buscaCEP() {
    const cep = document.getElementById('cep').value;
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
                document.getElementById('local').value = data.logradouro;
            } else {
            	console.error('Erro ao add endereco:', error);
            }
        })
        .catch(error => {
            console.error('Erro ao buscar CEP:', error);
        });
}

$(document).ready(function() {
  $('#telefone').inputmask('(99) 9 999[9] 9999');
});

$(document).ready(function() {
  $('#cep').inputmask('99999999');
});
</script>
</html>