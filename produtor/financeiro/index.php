<?php 

	$page_name = "Financeiro";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/functions/money.php";
	require "../../config/functions/app.php";
	require "../../config/cdn.php";
	require "../app/producer_vars.php";

	$id = $producer['id'];
	$user_id = $_SESSION['user_producer']['id'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/financeiro.css">
</head>
<body>
	<?php require "../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div class="row">
			<div class="col-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-wallet iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div style="padding-left: 8px;" class="align">
								<label style="line-height: 1.2;" class="btmText">
									<?php echo 'R$ ' . number_format(toWithdraw($id, $conn), 2,',','.'); ?>
								</label><br>
								<label class="topText">Disponível para Saque</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-vault iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div style="padding-left: 8px;" class="align">
								<label style="line-height: 1.2;" class="btmText">
									<?php echo 'R$ ' . number_format(descLucro(toReceive($id, $conn), $config['lucro']), 2,',','.'); ?>
								</label><br>
								<label class="topText">A receber</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-vault iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div style="padding-left: 8px;" class="align">
								<label style="line-height: 1.2;" class="btmText">
								<?php 

								$query = "SELECT SUM(valor) AS total_registros FROM tickets_saled
								          WHERE status = 1
								          AND event_id IN (SELECT id FROM events WHERE business_id = '$user_id')";

								$result = $conn->query($query);
								if ($result) {
								    $row = $result->fetch_assoc();
								    $total = $row["total_registros"];
								    if ($total == null) { $total = 0; }
								}

								echo 'R$ ' . number_format(descLucro($total, $config['lucro']), 2,',','.')

								?>
								</label><br>
								<label class="topText">Total de vendas (liquido)</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="text-align: right;" class="col-3">
				<div class="acoes align">
					
					<!-- exportar -->
					<button onclick="" type="button" class="act_money" type="button">
						<i class="fa-solid fa-money-bill-transfer"></i>
						Sacar
					</button>
					
					<!-- exportar -->
					<button onclick="exportToCSV('finan_export')" type="button" class="act_money" type="button">
						<i class="fa-solid fa-file-csv"></i>
						Exportar
					</button>
					
				</div>
			</div>
			<div style="margin-top: 20px;" class="col-12">
				<div class="module">
					<table class="table" id="finan_export">
						<thead>
							<tr>
								<th class="left">Code</th>
								<th class="left">Evento</th>
								<th class="left">Cliente</th>
								<th class="left">Ingresso</th>
								<th class="center">Qntd</th>
								<th class="center">Taxa</th>
								<th class="center">Valor Liquido</th>
								<th class="center"></th>
								<th class="right"></th>
							</tr>
						</thead>
						<tbody>
							<?php // [Lancelot]: faz a listagem dos eventos do usuário
							$consulta = "SELECT tickets_saled.id, events.title AS evento, tickets_saled.ticket, users.nome AS cliente, tickets_saled.qntd, tickets_saled.valor AS total, tickets_saled.status, tickets_saled.invoice
							             FROM tickets_saled
							             INNER JOIN events ON tickets_saled.event_id = events.id
							             INNER JOIN users ON tickets_saled.user_id = users.id
							             WHERE events.business_id = '$id_producer'
							             AND tickets_saled.status != 4
							             LIMIT 50";
							$con = $conn->query($consulta) or die($conn->error);
							while($dado = $con->fetch_array()) { ?>
							<tr>
							    <th class="align-middle left">
							        <?php echo $dado['id']; ?>
							    </th>
							    <td class="align-middle left">
							        <?php echo $dado['evento']; ?>
							    </td>
							    <td class="align-middle left">
							        <?php echo $dado['cliente']; ?>
							    </td>
							    <td class="align-middle left">
							        <?php echo $dado['ticket']; ?>
							    </td>
							    <td class="align-middle center">
							        <?php echo $dado['qntd']; ?>
							    </td>
							    <td class="align-middle center">
							        <?php echo '- R$ ' . number_format(calcLucro($dado['total'], $config['lucro']), 2,',','.'); ?>
							    </td>
							    <td class="align-middle center">
							        <?php echo 'R$ ' . number_format(descLucro($dado['total'], $config['lucro']), 2,',','.'); ?>
							    </td>
							    <td class="align-middle center">
							    	<?php 

							    		$stats = statusConvert($dado['status']);
							    		echo '<label class="stats" style="border-color: '.$stats["color"].'; color: '.$stats["color"].';">'.$stats["message"].'</label>';

							    	?>
							    </td>
							    <td class="align-middle right actions">
							        <?php if (!empty($dado['invoice']) AND $dado['status'] == 1) { ?>
							            <i onclick="window.open('<?php echo $dado['invoice'] ?>', '_blank');" class="fa-regular fa-file-lines"></i>
							        <?php } ?>
							    </td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function exportToCSV(table) {
    var table = document.getElementById(table);
    var csv = [];
    for (var i = 0; i < table.rows.length; i++) {
        var row = table.rows[i];
        var rowData = [];
        for (var j = 0; j < row.cells.length - 1; j++) {
            rowData.push('"' + row.cells[j].textContent + '"');
        }
        csv.push(rowData.join(','));
    }
    var csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'exported_data.csv');
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script>
</html>