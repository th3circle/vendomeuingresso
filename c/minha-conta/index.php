<?php 

	$page_name = 'Minha Conta';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (isset($_SESSION['user_consumer'])) {

		$id = $_SESSION['user_consumer']['id'];
		$query = "SELECT * FROM users WHERE id = '$id'";
		$mysqli_query = mysqli_query($conn, $query);
		while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

	} else {
		header('Location: ' . $config['app_local'] . '/login');
	}

	// ===================================================
	// ====================================  functions  ==
	// ===================================================

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
		$nascimento 				= date('Y-m-d', strtotime($_POST['nascimento']));
		$cpf 						= $_POST['cpf'];

		$query = "UPDATE users SET nome = '$name', surname = '$surname', telefone = '$telefone', email = '$email', nascimento = '$nascimento', address_cep = '$endereco_cep', address_cidade = '$endereco_cidade', address_estado = '$endereco_estado', address_longradouro = '$endereco_longradouro', cpf = '$cpf' WHERE id = '$id'";
	    if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

	}

	if (isset($_FILES['pp'])) {

		$pp = $_FILES['pp']['tmp_name'];
		$destination = '../../assets/pp/consumer/' . $id . '.jpg';
		if (move_uploaded_file($pp, $destination)) {

			$newName = $id . '.jpg';
			$query = "UPDATE users SET pp = '$newName' WHERE id = '$id'";
			if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

		}

	}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick-theme.css">

	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/home.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/consumer/minha-conta.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

</head>
<body>
<?php if (isMobileDevice()) { require "../../app/topbar_mobile.php"; } else { require "../../app/topbar.php"; } ?>

	<div style="margin-top: 100px;" class="container firtscontainer">
		<div style="margin-top: 20px;" class="row">
			<div class="col-11 col-lg-3 mx-auto">
				<div class="module profile_pp" style="background: url('<?php echo $config['app_local'] . '/assets/pp/consumer/' . $consumer['pp'] ?>');"	></div>
				<span id="clickUpdate"><i class="fa-regular fa-pen-to-square changePic"></i></span>
				<form action="" method="POST" enctype="multipart/form-data" id="formPP">
					<input type="file" name="pp" id="inputPP" style="display: none;">
				</form>
				<ul class="left_menu">
					<a href="<?php echo $config['app_local'] ?>/c/meus-ingressos"><li class=""><i class="fa-solid fa-ticket"></i> Meus Ingressos</li></a>
					<li><hr></li>
					<a href="<?php echo $config['app_local'] ?>/c/minha-conta"><li class="ative"><i class="fa-solid fa-circle-user"></i> Minha Conta</li></a>
					<a href="<?php echo $config['app_local'] ?>/c/revenda"><li><i class="fa-solid fa-shop fa-sm"></i> Revenda</li></a>
					<a href="<?php echo $config['app_local'] ?>/app/logout.php"><li><i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i> Sair</li></a>
				</ul>
			</div>
			<div class="col-12 col-lg-9">
				<?php if ($user['verify_email'] == false) { ?>
				<div <?php if (isset($cor)) { echo 'style="background: '.$cor.' !important;"'; } ?> class="alert_email">
					<div class="row">
						<div class="col-8 col-lg-10">
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
						<div style="text-align: right;" class="col-4 col-lg-2 resendDiv">
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
							<div class="col-12 col-lg-4">
								<label class="input">Nome: <b class="req">*</b></label>
								<input required value="<?php if(isset($user['nome'])) {echo $user['nome'];} ?>" type="text" name="name">
							</div>
							<div class="col-12 col-lg-4">
								<label class="input">Sobrenome: <b class="req">*</b></label>
								<input required value="<?php if(isset($user['surname'])) {echo $user['surname'];} ?>" type="text" name="surname">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-12 col-lg-4">
								<label class="input">Telefone:</label>
								<input required value="<?php if(isset($user['telefone'])) {echo $user['telefone'];} ?>" id="telefone" type="text" name="telefone">
							</div>
							<div class="col-12 col-lg-5">
								<label class="input">E-mail: <b class="req">*</b></label>
								<input required value="<?php if(isset($user['email'])) {echo $user['email'];} ?>" type="email" name="email">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-12 col-lg-2">
								<label class="input">CEP: <b class="req">*</b></label>
								<input required onkeyup="buscaCEP()" value="<?php if(isset($user['address_cep'])) {echo $user['address_cep'];} ?>" type="text" id="cep_minhaConta" name="endereco_cep">
							</div>
							<div class="col-12 col-lg-3">
								<label class="input">Cidade: <b class="req">*</b></label>
								<input required <?php if(isset($user['address_cidade'])) {echo 'value="' . $user['address_cidade'] . '"';} ?> type="text" id="cidade" name="endereco_cidade">
							</div>
							<div class="col-12 col-lg-3">
								<label class="input">Estado: <b class="req">*</b></label>
								<input required <?php if(isset($user['address_estado'])) {echo 'value="' . $user['address_estado'] . '"';} ?> type="text" id="estado" name="endereco_estado">
							</div>
							<div class="col-12 col-lg-4">
								<label class="input">Endereço: <b class="req">*</b></label>
								<input required <?php if(isset($user['address_longradouro'])) {echo 'value="' . $user['address_longradouro'] . '"';} ?> type="text" id="longradouro" name="endereco_longradouro">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-12 col-lg-3">
								<label class="input">CPF: <b class="req">*</b></label>
								<input required value="<?php if(isset($user['cpf'])) {echo $user['cpf'];} ?>" id="cpf" type="text" name="cpf">
							</div>
							<div class="col-12 col-lg-4">
								<label class="input">Data de Nascimento: <b class="req">*</b></label>
								<input max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required value="<?php if(isset($user['nascimento'])) {echo date('Y-m-d', strtotime($user['nascimento']));} ?>" type="date" name="nascimento">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-8 col-lg-4">
								<label class="input">Alterar Senha:</label>
								<input onclick="value=''" id="input_pass" minlength="8" type="password" name="nova_senha">
							</div>
							<div class="col-2">
								<button style="padding: 10px 15px !important; margin-top: 8px;" type="button" id="buttonUpdatePass" class="act_money">Alterar</button>
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

<?php require "../../app/footer.php"; ?>
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
            var novaSenha = inputPass.value;
            senhaInput.value = novaSenha;
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
    const cep = document.getElementById('cep_minhaConta').value;
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
  $('#cep_minhaConta').inputmask('99999999');
});

$(document).ready(function() {
  $('#cpf').inputmask('999.999.999-99');
});
</script>
</html>