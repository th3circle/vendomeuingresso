<?php 

	$page_name = "Minha Conta";
	require "../../../config/conn.php";
	require "../../../config/geral.php";
	require "../../../config/cdn.php";
	require "../../app/admin_vars.php";

	$user_id = $_GET['id'];

	$query = "SELECT * FROM users WHERE id = '$user_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

// if (isset($_POST['nome'])) {

// 	$nome 						= $_POST['nome'];
// 	$sobrenome 					= $_POST['sobrenome'];
// 	$email 						= $_POST['email'];

// 	$query = "UPDATE users SET nome = '$nome', surname = '$sobrenome', email = '$email' WHERE id = '$id'";
//     if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

// }

// if (isset($_FILES['pp'])) {

// 	$pp = $_FILES['pp']['tmp_name'];
// 	$destination = '../../assets/pp/superadmin/' . $id . '.jpg';
// 	if (move_uploaded_file($pp, $destination)) {

// 		$newName = $id . '.jpg';
// 		$query = "UPDATE superadmin SET pp = '$newName' WHERE id = '$id'";
// 		if ($conn->query($query) === TRUE) { echo '<script>window.location.href="./";</script>'; }

// 	}

// }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/financeiro.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/minha-conta.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/vars.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body>
	<?php require "../../app/leftbar_admin.php"; ?>
	<div class="container">
		<div style="margin-top: 20px;" class="row">
			<div class="col-3">
				<div id="clickUpdate" class="module profile_pp" style="background: url('../../../assets/pp/consumer/<?php
				    if (empty($user['pp'])) {
				        echo 'no-picture.png';
				    } else {
				        echo $user['pp'];
				    }
				?>');"></div>
				<form action="" method="POST" enctype="multipart/form-data" id="formPP">
					<input type="file" name="pp" id="inputPP" style="display: none;">
				</form>
			</div>
			<div class="col-9">
				<div style="margin-bottom: 10px;" class="row">
					<div class="col-8">
						<h4 class="title align">Dados do Usuário:</h4>
					</div>
					<div style="text-align: right;" class="col">
						<div class="acoes align">
							
							<!-- sacar -->
							<button form="updateProfile" class="act_money">
								<i class="fa-solid fa-floppy-disk"></i>
								Salvar
							</button>
							
						</div>
					</div>
				</div>
				<div class="module">
					<form method="POST" action="#" id="updateProfile">
						<div class="row">
							<div class="col-4">
								<label class="input">Nome: <b class="req">*</b></label>
								<input value="<?php if(isset($user['nome'])) {echo $user['nome'];} ?>" type="text" name="nome">
							</div>
							<div class="col-4">
								<label class="input">Sobrenome: <b class="req">*</b></label>
								<input value="<?php if(isset($user['surname'])) {echo $user['surname'];} ?>" type="text" name="surname">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-3">
								<label class="input">Telefone: <b class="req">*</b></label>
								<input value="<?php if(isset($user['telefone'])) {echo $user['telefone'];} ?>" type="telefone" name="telefone">
							</div>
							<div class="col-5">
								<label class="input">E-mail: <b class="req">*</b></label>
								<input value="<?php if(isset($user['email'])) {echo $user['email'];} ?>" type="email" name="email">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-3">
								<label class="input">CPF: <b class="req">*</b></label>
								<input value="<?php if(isset($user['cpf'])) {echo $user['cpf'];} ?>" type="cpf" name="cpf">
							</div>
							<div class="col-3">
								<label class="input">Data Nascimento: <b class="req">*</b></label>
								<input value="<?php if(isset($user['nascimento'])) {echo $user['nascimento'];} ?>" type="date" name="nascimento">
							</div>
							<div class="col-12">
								<hr>
							</div>
							<div class="col-2">
								<label class="input">CEP: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_cep'])) {echo $user['address_cep'];} ?>" type="text" name="address_cep">
							</div>
							<div class="col-2">
								<label class="input">Cidade: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_cidade'])) {echo $user['address_cidade'];} ?>" type="text" name="address_cidade">
							</div>
							<div class="col-1">
								<label class="input">UF: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_estado'])) {echo $user['address_estado'];} ?>" type="text" name="address_estado">
							</div>
							<div class="col-3">
								<label class="input">Logradouro: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_longradouro'])) {echo $user['address_longradouro'];} ?>" type="text" name="address_longradouro">
							</div>
							<div class="col-1">
								<label class="input">N.º: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_numero'])) {echo $user['address_numero'];} ?>" type="text" name="address_numero">
							</div>
							<div class="col-3">
								<label class="input">Complemento: <b class="req">*</b></label>
								<input value="<?php if(isset($user['address_complemento'])) {echo $user['address_complemento'];} ?>" type="text" name="address_complemento">
							</div>
						</div>
					</form>
				</div>
				<div style="margin-top: 25px;" class="row">
					<div class="col-12">
						<h4 class="title">Histórico de Compra</h4>
					</div>
					<div class="col-12">
						<div class="module">
							<table class="table" id="finan_export">
								<thead>
									<tr>
										<th class="left">Code</th>
										<th class="left">Evento</th>
										<th class="left">Ingresso</th>
										<th class="center">Qntd</th>
										<th class="center">Valor Total</th>
										<th class="center">Data</th>
									</tr>
								</thead>
								<tbody>
								<?php // [Lancelot]: faz a listagem dos eventos do usuário
								$consulta = "SELECT tickets_saled.id, tickets_saled.date_inserted, events.title AS evento, events.tipo AS event_tipo, tickets_saled.ticket, users.nome AS cliente_name, users.surname AS cliente_surname, tickets_saled.qntd, tickets_saled.valor * tickets_saled.qntd AS total, tickets_saled.status, tickets_saled.invoice
								             FROM tickets_saled
								             INNER JOIN events ON tickets_saled.event_id = events.id
								             INNER JOIN users ON tickets_saled.user_id = users.id
								             WHERE tickets_saled.user_id = '$user_id'";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { ?>
								<tr>
								    <th class="align-middle left"><?php echo $dado['id']; ?></th>
								    <td class="align-middle left"><?php echo $dado['evento'] ?></td>
								    <td class="align-middle left"><?php echo $dado['ticket']; ?></td>
								    <td class="align-middle center"><?php echo $dado['qntd']; ?></td>
								    <td class="align-middle center"><?php echo 'R$ ' . number_format($dado['total'], 2,',','.'); ?></td>
								    <td class="align-middle center"><?php echo date('d/m/Y', strtotime($dado['date_inserted'])) ?></td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
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