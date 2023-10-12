<?php 

	$page_name = 'Novo Evento';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (!isset($_POST['step-one']) AND !isset($_POST['step-two'])) { header('Location: ../'); }

	$event = $_SESSION['event_data'];

	$event = array(
		"nome" => $_SESSION['event_data']['nome'],
		"descricao" => $_SESSION['event_data']['descricao'],
		"categoria" => $_SESSION['event_data']['categoria'],
		"capa" => $_SESSION['event_data']['capa'],
		"cep" => $_POST['endereco_cep'],
		"bairro" => $_POST['endereco_bairro'],
		"cidade" => $_POST['endereco_cidade'],
		"estado" => $_POST['endereco_estado'],
		"rua" => $_POST['endereco_local'],
	);

	$_SESSION['event_data'] = $event;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/novo-evento.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

</head>
<body>
	<form method="POST" action="../ingressos/" enctype="multipart/form-data">

		<input type="hidden" name="step-one" value="true">
		<input type="hidden" name="step-two" value="true">

		<div class="alignContent">
			<div style="margin-bottom: 30px;" class="row">
				<div class="col-1">
					<img class="logo" src="<?php echo $config['logo_principal'] ?>">
				</div>
				<div class="col-5">
					<div class="align">
						<label class="title_top"><?php echo $event['nome']; ?></label>
					</div>
				</div>
				<div style="text-align: right;" class="col-6">
					<div class="align">
						<button type="button" onclick="window.location.href='../../'" class="act cancel">
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
			<div class="progressbar"><div style="animation: expandWidth65 1s ease-in-out; width: 65%;" class="bar"></div></div>
			<div class="module">
				<div style="background: url('../../attachments/eventos/capas/<?php echo $event['nome'] . '_' . $event['capa']; ?>'); cursor: default !important;" id="capa" class="capa">
					<label style="opacity: 0 !important; cursor: default !important;" class="edit">
						<i class="fa-regular fa-pen-to-square"></i>
					</label>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="capa_details">Para garantir uma ótima apresentação do banner, sugerimos o uso de uma imagem no formato JPG com as dimensões de 1675x450 pixels.</p>
					</div>
				</div>
				<div class="contentInputs">

					<div class="row">
					    <div class="col-2">
					        <label style="z-index: 2; position: relative;" class="input">Data: <b class="req">*</b></label><br>
					        <div class="row">
					            <div class="col-9">
					                <input style="width: 140%; z-index: 1; position: relative;" min="<?php echo date('Y-m-d'); ?>" required type="date" class="address" name="data[]">
					            </div>
					            <div class="col-3">
					                <button class="trashDate" type="button" style="display: none;"><i class="fa-regular fa-trash-can"></i></button>
					            </div>
					        </div>
					    </div>
					    <div id="add_date" class="col-2">
					        <button type="button" id="addDateButton" class="act"><i style="margin-right: 5px;" class="fa-solid fa-plus"></i> Add. Data</button>
					    </div>
					</div>

					<script>
					document.getElementById('addDateButton').addEventListener('click', function() {
					    const clonedDia = document.querySelector('.col-2').cloneNode(true);

					    const clonedInput = clonedDia.querySelector('input[type="date"]');
					    clonedInput.value = '';
					    clonedInput.style.width = '100%';

					    // Adiciona o botão de exclusão apenas nas divs duplicadas
					    const trashButton = clonedDia.querySelector('.trashDate');
					    trashButton.style.display = 'inline';
					    trashButton.onclick = function() {
					        this.closest('.col-2').remove();
					    };

					    const addButton = document.getElementById('add_date');
					    addButton.parentElement.insertBefore(clonedDia, addButton);
					});
					</script>

				</div>
			</div>
		</div>
	</form>
</body>
</html>