<?php 

	$page_name = "Ajustes";
	require "../../../config/conn.php";
	require "../../../config/geral.php";
	require "../../../config/cdn.php";
	require "../../app/producer_vars.php";
	require '../../../vendor/autoload.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$id = $producer['id'];

	if (isset($_POST['saque']) AND $_POST['saque']['metodo'] == 'pix') {

		$met_saque = array(
			"metodo" => "pix",
			"chave" => $_POST['chave_pix'],
		);

		$met_saque = json_encode($met_saque);

	} elseif (isset($_POST['saque']) AND $_POST['saque']['metodo'] == 'transferencia') {

		$met_saque = array(
			"metodo" => "transferencia",
			"agencia" => $_POST['saque']['agencia'],
			"conta" => $_POST['saque']['conta'],
			"banco" => $_POST['saque']['banco'],
			"tipo_conta" => $_POST['saque']['tipo_conta'],
		);

		$met_saque = json_encode($met_saque);

	}

	if (isset($producer['vinculo_id']) AND !empty($producer['vinculo_id']) AND $producer['vinculo_id'] != '') {

		$userKid = true;

	} else {

		if (isset($_POST['saque'])) {
			$query = "UPDATE producer SET met_saque = '$met_saque' WHERE id = '$id'";
	        if ($conn->query($query) === TRUE) {
	        	echo '<script>window.location.href="./"</script>';
	        }
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/ajustes.css">
</head>
<body>
	<?php require "../../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div class="row">
			<div style="margin-bottom: 20px;" class="col-12">
				<form method="POST" action="" id="newMet">
					<div class="row">
						<div class="col-sm">
							<h5 class="title_module">Método de Saque</h5>
						</div>
						<?php 
							if (!empty($producer['met_saque'])) {
								$saque = json_decode($producer['met_saque'], true);
							}
						?>
						<div class="col-2">
							<label class="input">Método de Saque</label>
							<select onchange="mostrarOcultarBox()" id="saque_metodo" name="saque[metodo]">
								<option <?php if (isset($saque) AND $saque['metodo'] == 'pix') { echo 'selected'; } ?> value="pix">PIX</option>
								<option <?php if (isset($saque) AND $saque['metodo'] == 'transferencia') { echo 'selected'; } ?> value="transferencia">Transferência Bancária</option>
							</select>
						</div>
						<div id="transferencia_box" style="display: ;" class="col-6">
							<div class="row">
								<div class="col-2">
									<label class="input">Agência <b class="req">*</b></label>
									<input value="<?php if (!empty($saque) AND $saque['metodo'] == 'transferencia') { echo $saque['agencia']; } ?>" type="text" name="saque[agencia]">
								</div>
								<div class="col-4">
									<label class="input">Conta <b class="req">*</b></label>
									<input value="<?php if (!empty($saque) AND $saque['metodo'] == 'transferencia') { echo $saque['conta']; } ?>" type="text" name="saque[conta]">
								</div>
								<div class="col-3">
									<label class="input">Banco <b class="req">*</b></label>
									<input value="<?php if (!empty($saque) AND $saque['metodo'] == 'transferencia') { echo $saque['banco']; } ?>" type="text" name="saque[banco]">
								</div>
								<div class="col-3">
									<label class="input">Banco <b class="req">*</b></label>
									<select name="saque[tipo_conta]">
										<option <?php if (isset($saque) AND $saque['metodo'] == 'transferencia' AND $saque['tipo_conta'] == 'Conta Corrente') { echo 'selected'; } ?> >Conta Corrente</option>
										<option <?php if (isset($saque) AND $saque['metodo'] == 'transferencia' AND $saque['tipo_conta'] == 'Conta Poupança') { echo 'selected'; } ?> >Conta Poupança</option>
									</select>
								</div>
							</div>
						</div>
						<div id="box_pix" style="display: none;" class="col-3">
							<label class="input">Chave PIX: <b class="req">*</b></label>
							<input value="<?php if (!empty($saque) AND $saque['metodo'] == 'pix') { echo $saque['chave']; } ?>" type="text" name="chave_pix">
						</div>
						<div style="<?php if ($userKid == true) { echo 'display: none;'; } ?>" class="col-1">
							<button form="newMet" class="act">Salvar</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-3">
				<div class="module tip">
					<label class="titleTip">
						<i class="fa-solid fa-circle-info"></i>
						Atenção
					</label>
					<p class="descTip">
						O saque será efetuado automáticamente no período de até 3 (três) dias úteis após o encerramento do evento. Esta medida é tomada para a segurança de ambas as partes.
					</p>
					<div class="descTip">
						<i style="margin-right: 5px; color: var(--primaria);" class="fa-brands fa-pix fa-xl"></i>
						<b>Recebendo com o PIX:</b><br><br>
						Para receber o valor do evento através do PIX, basta cadastrar a chave ao lado. Fique atento para que a chave PIX cadastrada seja do titular do evento, caso contrário a transferência não poderá ser efetuada.
					</div>
				</div>
			</div>
			<div class="col-9">
				<div class="module">
					<div class="row">
						<div class="col-12">
							<table class="table">
								<thead>
									<tr>
										<th class="left">Data</th>
										<th class="center">Conta</th>
										<th class="left">Valor</th>
										<th class="center">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php // [Lancelot]: faz a listagem das categeorias
									if (isset($producer['vinculo_id']) AND !empty($producer['vinculo_id'])) { $id_certo = $producer['vinculo_id']; } else { $id_certo = $id; }
									$consulta = "SELECT * FROM withdrawals WHERE produtor = '$id_certo'";
									$con = $conn->query($consulta) or die($conn->error);
									while($dado = $con->fetch_array()) { ?>
									<tr>
										<td width="20%" class="left">
											<?php echo $dado['data']; ?>
										</td>
										<td width="15%" class="center">
											<?php echo $dado['conta'] ?>
										</td>
										<td width="30%" class="left">
											<?php echo $dado['valor'] ?>
										</td>
										<td width="15%" class="center">
											<?php if ($dado['status'] == 1) { 
												echo '<label class="status status_ativo">ENVIADO</label>'; 
											} elseif ($dado['status'] == 2) { 
												echo '<label class="status status_inativo">PROCESSANDO</label>'; 
											} else { 
												echo '<label class="status status_inativo">ERRO</label>'; 
											} ?>
										</td>
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
function mostrarOcultarBox() {
    var metodo = document.getElementById('saque_metodo').value;
    var transferenciaBox = document.getElementById('transferencia_box');
    var boxPix = document.getElementById('box_pix');

    if (metodo === 'pix') {
        transferenciaBox.style.display = 'none';
        boxPix.style.display = 'block';
    } else if (metodo === 'transferencia') {
        transferenciaBox.style.display = 'block';
        boxPix.style.display = 'none';
    }
}

// Inicialmente, chame a função para garantir que o estado inicial esteja correto.
mostrarOcultarBox();
</script>
<script>
function confirmAlert(msg, link) {
    var resposta = confirm(msg);
    if (resposta === true) {
        window.location.href = link;
    }
}
</script>
</html>