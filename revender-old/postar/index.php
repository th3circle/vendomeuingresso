<?php 

	$page_name = 'Revender';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	if (!isset($_SESSION['user_consumer'])) { header('Location: ../../login'); }

	$ticket_id 		= $_POST['id'];
	$user_id 		= $_SESSION['user_consumer']['id'];

	// user
	$query = "SELECT * FROM users WHERE id = '$user_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

	// ticket
	$query = "SELECT * FROM tickets_saled WHERE id = '$ticket_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($ticket_data = mysqli_fetch_array($mysqli_query)) { $ticket = $ticket_data; }

	// event
	$event_id = $ticket['event_id'];
	$query = "SELECT * FROM events WHERE id = '$event_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($event_data = mysqli_fetch_array($mysqli_query)) { $event = $event_data; }

	if (isset($_POST['public'])) {

		$tipo = 2;
		$business_id = $user['id'];
		$title = 'REVENDA: ' . $event['title'];

		$string = $ticket['ticket'];
		$days = date('Y-m-d', strtotime(substr($string, -10)));
		$days_json = '[' . json_encode($days) . ']';

		
		$posicaoDoisPontos = strpos($string, ':');
		$tipo = substr($string, 0, $posicaoDoisPontos);

		$qntd = $_POST['qntd'];
		$valor = str_replace("R$ ", "", $_POST['valor']);
		$obs = "REVENDA";

		$dados = [
		    $days => [
		        "id" => "",
		        "tipo" => $tipo,
		        "estoque" => $qntd,
		        "valor" => $valor,
		        "obs" => $obs
		    ]
		];

		$ingressos = json_encode($dados);

		$event_data = $days;

		// Query SQL com variáveis PHP
		$query = "INSERT INTO events (tipo, business_id, photo, banner, title, city, uf, local, description, days, ingressos, event_data, inserted_date, categoria, status)
		          SELECT '2', '$business_id', photo, banner, '$title', city, uf, local, description, '$days_json', '$ingressos', '$event_data', inserted_date, categoria, status
		          FROM events
		          WHERE id = '$event_id'";


		if ($conn->query($query) === TRUE) {

			$id_novo_evento = $conn->insert_id;
			$query = "UPDATE tickets_saled SET qntd = qntd - 1 WHERE id = '$ticket_id'";
			if ($conn->query($query) === TRUE) {
	        	header('Location: ../../evento/?id=' . $id_novo_evento);
	        }

		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/novo-evento.css">
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
</head>
<body>
	<form method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
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
						<button name="public" class="act next">
							Publicar
							<i class="fa-solid fa-chevron-right fa-sm"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="progressbar"><div style="width: 60%;" class="bar"></div></div>
			<div class="module">
				<div style="background: url('../../attachments/eventos/capas/<?php echo $event['title'] . '_' . $event['banner']; ?>');" id="capa" class="capa"></div>
				<div class="contentInputs">
					<div style="margin-top: 10px;" class="row">
						<div class="col-sm">
							<label class="input">Ingresso: <b class="req">*</b></label>
							<select class="address" disabled>
								<?php
								$consulta = "SELECT tickets_saled.*, events.*
											FROM tickets_saled
											INNER JOIN events ON tickets_saled.event_id = events.id
											WHERE events.status = 1 AND tickets_saled.status = 1;";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { $id_cat = $dado['id']; ?>
								<option value="<?php echo $dado['id'] ?>"><?php echo $dado['ticket']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-1">
							<label class="input">Qntd: <b class="req">*</b></label>
							<input min="1" max="<?php echo $ticket['qntd']; ?>" value="<?php echo $ticket['qntd']; ?>" type="number" class="address" name="qntd">
						</div>
						<div class="col-2">
							<label class="input">Valor: <b class="req">*</b></label>
							<input value="<?php echo $ticket['valor_un']; ?>" type="text" id="valor" onkeyup="formatMoney(this)" class="address" name="valor">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
<script>
function formatMoney(input) {
    let value = input.value;
    value = value.replace(/\D/g, "");
    value = parseFloat(value / 100).toFixed(2);
    value = value.replace(".", ",");
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    value = "R$ " + value;
    input.value = value;
}
document.getElementById('form').addEventListener('submit', function() {
    const precoInputs = document.querySelectorAll('.precoInput');
    precoInputs.forEach(input => {
        input.value = input.value.replace('R$ ', '').replace('.', '').replace(',', '.');
    });
});
</script>
</html>