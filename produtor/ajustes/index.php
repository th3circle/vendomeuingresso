<?php 

	$page_name = "Ajustes";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";
	require "../app/producer_vars.php";

	$id = $producer['id'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/ajustes.css">
</head>
<body>
	<?php require "../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div style="margin-top: 20px;" class="row">

			<div onclick="window.location.href='./usuarios/'" class="col-4">
				<div class="moduleSettings">
					<div class="row">
						<div class="col-3">
							<div class="iconModule">
								<i class="fa-solid fa-user-gear"></i>
							</div>
						</div>
						<div class="col">
							<div class="align">
								<label class="titleSettings">Usuários</label>
								<label class="descSettings">Configure os usuários de acesso ao sistema e portaria.</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div onclick="window.location.href='./metodo-de-saque/'" class="col-4">
				<div class="moduleSettings">
					<div class="row">
						<div class="col-3">
							<div class="iconModule">
								<i class="fa-brands fa-pix"></i>
							</div>
						</div>
						<div class="col">
							<div class="align">
								<label class="titleSettings">Método de Saque</label>
								<label class="descSettings">Configure a conta ou chave PIX para receber a sua transferência.</label>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</body>
</html>