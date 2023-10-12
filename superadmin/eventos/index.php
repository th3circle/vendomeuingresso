<?php 

	$page_name = "Eventos";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";
	require "../app/admin_vars.php";

	$id = $superadmin['id'];

	if (isset($_POST['filter'])) {

		$dataInicial	= $_POST['filter_dateInit'];
		$dataFinal		= $_POST['filter_dateEnd'];
		$status 		= $_POST['filter_status'];

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/superadmin/eventos.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">
</head>
<body>
	<?php require "../app/leftbar_admin.php"; ?>
	<div class="container">
		<form method="POST" action="" id="filter">
		<div class="row">

			<div class="col-12 col-sm-4 col-md-5 col-lg-5 col-xl-4 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-calendar-day iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status != 0";
										if (isset($_POST['filter']) AND $_POST['filter_status'] != 0) { 
											$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status != 0 AND event_data BETWEEN '$dataInicial' AND '$dataFinal'";
										} elseif (isset($_POST['filter']) AND $_POST['filter_status'] == 0) {
											$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status != 0  AND event_data BETWEEN '$dataInicial' AND '$dataFinal'";
										}
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Ativos</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-4 col-md-5 col-lg-5 col-xl-4 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-circle-check iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status = 2";
										if (isset($_POST['filter']) AND $_POST['filter_status'] != 0) { 
											$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status = 2 AND event_data BETWEEN '$dataInicial' AND '$dataFinal'";
										} elseif (isset($_POST['filter']) AND $_POST['filter_status'] == 0) {
											$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status = 2  AND event_data BETWEEN '$dataInicial' AND '$dataFinal'";
										}
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Encerrados</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-4 col-xxl-2">
				<div class="align">
					<label class="input">Data Início</label>
					<input required value="<?php if (isset($_POST['filter_dateInit'])) { echo $_POST['filter_dateInit']; } ?>" type="date" name="filter_dateInit">
				</div>
			</div>

			<div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-4 col-xxl-2">
				<div class="align">
					<label class="input">Data Final</label>
					<input required value="<?php if (isset($_POST['filter_dateEnd'])) { echo $_POST['filter_dateEnd']; } ?>" type="date" name="filter_dateEnd">
				</div>
			</div>

			<div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-4 col-xxl-1">
				<div class="align">
					<label class="input">Status</label>
					<select style="padding: 10px;" name="filter_status">
						<option <?php if (isset($_POST['filter_status']) AND $_POST['filter_status'] == 0) { echo 'selected'; } ?> value="0">Todos</option>
						<option <?php if (isset($_POST['filter_status']) AND $_POST['filter_status'] == 1) { echo 'selected'; } ?> value="1">Ativo</option>
						<option <?php if (isset($_POST['filter_status']) AND $_POST['filter_status'] == 2) { echo 'selected'; } ?> value="2">Encerrado</option>
						<option <?php if (isset($_POST['filter_status']) AND $_POST['filter_status'] == 3) { echo 'selected'; } ?> value="3">Saque Disponível</option>
						<option <?php if (isset($_POST['filter_status']) AND $_POST['filter_status'] == 4) { echo 'selected'; } ?> value="4">Arquivado</option>
					</select>
				</div>
			</div>

			<div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-4 col-xxl-1">
				<button name="filter" form="filter" style="margin-top: 5px; width: 100%;" class="act align">
					<i class="fa-solid fa-magnifying-glass"></i>
				</button>
			</div>

		</div>
		</form>
		<div style="margin-top: 20px;" class="row">
			<div class="module">
				<table class="table">
					<thead>
						<tr>
							<th style="text-align: left;" scope="col"></th>
							<th style="text-align: left;" scope="col">Produtor</th>
							<th style="text-align: left;" scope="col">Título</th>
							<th style="text-align: left;" scope="col">Cidade</th>
							<th style="text-align: center;" scope="col">Data</th>
							<th style="text-align: center;" scope="col">Categoria</th>
							<th style="text-align: center;" scope="col">Status</th>
							<th style="text-align: left;" scope="col"></th>
						</tr>
					</thead>
					<tbody>

						<?php // [Lancelot]: faz a listagem dos eventos do usuário
						$consulta = "SELECT events.*, CONCAT(producer.name, ' ', producer.surname) AS produtor, categories.nome AS categoria
						             FROM events
						             INNER JOIN producer ON events.business_id = producer.id
						             INNER JOIN categories ON events.categoria = categories.id
						             ORDER BY event_data DESC";

						if (isset($_POST['filter']) && $_POST['filter_status'] != 0) { 
						    $consulta = "SELECT events.*, CONCAT(producer.name, ' ', producer.surname) AS produtor, categories.nome AS categoria
						                 FROM events
						                 INNER JOIN producer ON events.business_id = producer.id
						                 INNER JOIN categories ON events.categoria = categories.id
						                 WHERE event_data BETWEEN '$dataInicial' AND '$dataFinal'
						                 AND events.status = '$status'
						                 ORDER BY event_data DESC";
						} elseif (isset($_POST['filter']) && $_POST['filter_status'] == 0) {
						    $consulta = "SELECT events.*, CONCAT(producer.name, ' ', producer.surname) AS produtor, categories.nome AS categoria
						                 FROM events
						                 INNER JOIN producer ON events.business_id = producer.id
						                 INNER JOIN categories ON events.categoria = categories.id
						                 WHERE event_data BETWEEN '$dataInicial' AND '$dataFinal'
						                 ORDER BY event_data DESC";
						}
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { ?>
						<tr>
						    <th class="align-middle" style="width: 7%; text-align: left">
						        <?php echo $dado['id']; ?>
						    </th>
						    <td class="align-middle" style="text-align: left">
						        <?php echo ucwords($dado['produtor']); ?>
						    </td>
						    <td class="align-middle" style="text-align: left">
						        <?php echo $dado['title']; ?>
						    </td>
						    <td class="align-middle" style="text-align: left">
						        <?php echo $dado['city'] . ', ' . $dado['uf']; ?>
						    </td>
						    <td class="align-middle" style="width: 7%; text-align: center">
						        <?php echo date('d/m/Y', strtotime($dado['event_data'])); ?>
						    </td>
						    <td class="align-middle" style="width: 10%; text-align: center">
						        <?php echo $dado['categoria']; ?>
						    </td>
						    <td class="align-middle" style="width: 7%; text-align: center">
						    	<label class="status status_<?php echo $dado['status']; ?>">
						        	<?php if ($dado['status'] == 0) {
						                echo strtoupper('Inativo');
						            } elseif ($dado['status'] == 1) {
						                echo strtoupper('Ativo');
						            } elseif ($dado['status'] == 2) {
						                echo strtoupper('Encerrado');
						            } elseif ($dado['status'] == 3) {
						                echo strtoupper('Saque');
						            } elseif ($dado['status'] == 4) {
						                echo strtoupper('Arquivado');
						            } ?>
						        </label>
						    </td>
						    <td class="align-middle" style="width: 5%; text-align: right">
						    	<i onclick="window.location.href='./ver/?id=<?php echo $dado['id']; ?>'" style="margin-left: 5px;" class="fa-regular fa-eye fa-sm"></i>
						    	<i onclick="return confirm('Certeza? Esta ação é irreversível')" style="margin-left: 5px;" class="fa-regular fa-trash-can fa-sm"></i>
						    </td>
						</tr>
						<?php } ?>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>