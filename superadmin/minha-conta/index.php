<?php 

	$page_name = "Minha Conta";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";
	require "../app/admin_vars.php";

	$id = $superadmin['id'];

	if (isset($_GET['sendMail'])) {
		$cor = "#4baf00";
		$msg = "E-mail enviado com sucesso! Acesse através de um aparelho logado e confirme a sua conta!";
	}

	if (isset($_POST['nome'])) {

		$nome 						= $_POST['nome'];
		$sobrenome 					= $_POST['sobrenome'];
		$email 						= $_POST['email'];

		$query = "UPDATE superadmin SET nome = '$nome', sobrenome = '$sobrenome', email = '$email' WHERE id = '$id'";
	    if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

	}

	if (isset($_FILES['pp'])) {

		$pp = $_FILES['pp']['tmp_name'];
		$destination = '../../assets/pp/superadmin/' . $id . '.jpg';
		if (move_uploaded_file($pp, $destination)) {

			$newName = $id . '.jpg';
			$query = "UPDATE superadmin SET pp = '$newName' WHERE id = '$id'";
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
	<?php require "../app/leftbar_admin.php"; ?>
	<div class="container">
		<div style="margin-top: 20px;" class="row">
			<div class="col-3">
				<div class="module profile_pp" style="background: url('../../assets/pp/superadmin/<?php
				    if (empty($superadmin['pp'])) {
				        echo 'no-picture.jpg';
				    } else {
				        echo $superadmin['pp'];
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
				<div class="module">
					<form method="POST" action="#" id="updateProfile">
						<div class="row">
							<div class="col-4">
								<label class="input">Nome: <b class="req">*</b></label>
								<input required value="<?php if(isset($superadmin['nome'])) {echo $superadmin['nome'];} ?>" type="text" name="nome">
							</div>
							<div class="col-4">
								<label class="input">Sobrenome: <b class="req">*</b></label>
								<input required value="<?php if(isset($superadmin['sobrenome'])) {echo $superadmin['sobrenome'];} ?>" type="text" name="sobrenome">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-5">
								<label class="input">E-mail: <b class="req">*</b></label>
								<input required value="<?php if(isset($superadmin['email'])) {echo $superadmin['email'];} ?>" type="email" name="email">
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
</body>
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