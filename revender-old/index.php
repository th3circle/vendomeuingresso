<?php 

	$page_name = 'Revender';

	require "../config/conn.php";
	require "../config/geral.php";
	require "../config/cdn.php";

	if (!isset($_SESSION['user_consumer'])) { header('Location: ../login'); }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/produtor/novo-evento.css">
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
</head>
<body>
	<form method="POST" action="./postar/" enctype="multipart/form-data">
		<div style="margin-top: 10rem !important;" class="alignContent">
			<div style="margin-bottom: 30px;" class="row">
				<div class="col-1">
					<img class="logo" src="<?php echo $config['logo_principal'] ?>">
				</div>
				<div class="col-5">
					<div class="align">
						<label class="title_top">Revender Ingresso</label>
					</div>
				</div>
				<div style="text-align: right;" class="col-6">
					<div class="align">
						<button type="button" onclick="window.location.href='../'" class="act cancel">
							<i class="fa-solid fa-shop fa-sm"></i>
							Cancelar
						</button>
						<button class="act next">
							Avançar
							<i class="fa-solid fa-chevron-right fa-sm"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="progressbar"><div style="width: 15%;" class="bar"></div></div>
			<div class="module">
				<div class="contentInputs">
					<div class="row">
						<div class="col-12">
							<label class="input">Escolha o Ingresso: <b class="req">*</b></label>
							<select name="id">
								<?php
								$consulta = "SELECT tickets_saled.*, events.*, tickets_saled.id AS tick_id
											FROM tickets_saled
											INNER JOIN events ON tickets_saled.event_id = events.id
											WHERE events.status = 1 AND tickets_saled.status = 1;";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { $id_cat = $dado['id']; ?>
								<option value="<?php echo $dado['tick_id'] ?>"><?php echo $dado['ticket']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>