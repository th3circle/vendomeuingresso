<?php 

	$page_name = "Financeiro";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../app/admin_vars.php";
	require "../../config/functions/money.php";
	require "../../config/functions/app.php";
	require "../../config/cdn.php";

	$id = $superadmin['id'];

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
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<?php require "../app/leftbar_admin.php"; ?>
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
								<?php 

									$query = "SELECT SUM(valor * qntd) AS total
											  FROM tickets_saled
											  WHERE status = 1";

									$result = $conn->query($query);

									if ($result && $result->num_rows > 0) {

									    $row = $result->fetch_assoc();
									    $total = $row['total'];
									    	
									    if ($total == null) {
									    	$total = 0;
									    }

									    echo 'R$ ' . number_format($total, 2,',','.');

									}

								?>
								</label><br>
								<label class="topText">Vendas Aprovadas</label>
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

									$query = "SELECT SUM(valor * qntd) AS total
											  FROM tickets_saled
											  WHERE status = 1";

									$result = $conn->query($query);

									if ($result && $result->num_rows > 0) {

									    $row = $result->fetch_assoc();
									    $total = $row['total'];
									    	
									    if ($total == null) {
									    	$total = 0;
									    }

									    echo 'R$ ' . number_format((($config['lucro'] / 100) * $total), 2,',','.');

									}

								?>
								</label><br>
								<label class="topText">Lucros Aprovados</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="text-align: right;" class="col-6">
				<div class="acoes align">
					
					<!-- exportar -->
					<button onclick="exportToCSV('finan_export')" type="button" class="act_money" type="button">
						<i class="fa-solid fa-file-csv"></i>
						Exportar
					</button>
					
				</div>
			</div>
			<div style="margin-top: 20px;" class="col-12">
				<div class="module">
					<div style="margin-bottom: 20px !important;" class="row">
						<div class="col-2">
							<label style="box-shadow: none !important; width: auto !important; border: none !important; padding: 0px 10px !important; height: auto !important;"  class="input">Data Inicial</label>
							<input type="date" id="dataInicial" placeholder="Data Inicial">
						</div>
						<div class="col-2">
							<label style="box-shadow: none !important; width: auto !important; border: none !important; padding: 0px 10px !important; height: auto !important;"  class="input">Data Final</label>
							<input type="date" id="dataFinal" placeholder="Data Final">
						</div>
						<div class="col-4">
							<button style="padding: 11px 15px !important; margin-top: 8px;" class="act_money" id="aplicarFiltro">Aplicar Filtro</button>
							<button style="padding: 11px 15px !important; margin-top: 8px;" class="act_money" id="limparFiltro">Limpar Filtro</button>
						</div>
					</div>
					<table class="table" id="finan_export">
						<thead>
							<tr>
								<th class="left">Code</th>
								<th class="left">Cliente</th>
								<th class="left">Ingresso</th>
								<th class="center">Qntd</th>
								<th class="center">Valor Total</th>
								<th class="center">Data</th>
								<th class="center">Evento</th>
								<th class="center">Tipo</th>
								<th class="center"></th>
								<th class="right"></th>
							</tr>
						</thead>
						<tbody>
						<?php // [Lancelot]: faz a listagem dos eventos do usuário
						$consulta = "SELECT tickets_saled.id, events.title AS evento, events.tipo AS event_tipo, tickets_saled.ticket, users.nome AS cliente_name, users.surname AS cliente_surname, tickets_saled.qntd, tickets_saled.valor * tickets_saled.qntd AS total, tickets_saled.status, tickets_saled.invoice
						             FROM tickets_saled
						             INNER JOIN events ON tickets_saled.event_id = events.id
						             INNER JOIN users ON tickets_saled.user_id = users.id";
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { ?>
						<tr>
						    <th class="align-middle left"><?php echo $dado['id']; ?></th>
						    <td class="align-middle left"><?php echo $dado['cliente_name'] . ' ' . $dado['cliente_surname']; ?></td>
						    <td class="align-middle left"><?php echo $dado['ticket']; ?></td>
						    <td class="align-middle center" style="text-align: center !important;"><?php echo $dado['qntd']; ?></td>
						    <td class="align-middle center"><?php echo 'R$ ' . number_format($dado['total'], 2,',','.'); ?></td>
						    <td class="align-middle center"><?php echo substr($dado['ticket'], -10) ?></td>
						    <td class="align-middle center"><?php echo $dado['evento'] ?></td>
						    <td class="align-middle center"><?php if ($dado['event_tipo']  == 1) { echo 'Produtor'; } else { echo 'Revenda'; } ?></td>
						    <td class="align-middle center" style="text-align: center;"><?php $stats = statusConvert($dado['status']);echo '<label class="stats" style="border-color: '.$stats["color"].'; color: '.$stats["color"].';">'.$stats["message"].'</label>';?></td>
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
			<div style="margin-top: 25px;" class="col-3">

				<?php
				// Calcula o total da tabela tickets_saled onde o status = 1
				$queryStatus1 = "SELECT SUM(valor) AS total_status_1 FROM tickets_saled WHERE status = 1";
				$resultStatus1 = $conn->query($queryStatus1);
				$totalStatus1 = 0;
				if ($resultStatus1) {
				    $rowStatus1 = $resultStatus1->fetch_assoc();
				    $totalStatus1 = $rowStatus1["total_status_1"];
				}

				// Calcula o total da tabela tickets_saled onde o event_id é de um events.tipo = 1
				$queryTipo1 = "SELECT SUM(ts.valor) AS total_tipo_1 FROM tickets_saled ts
				               INNER JOIN events e ON ts.event_id = e.id
				               WHERE e.tipo = 1 AND ts.status = 1";
				$resultTipo1 = $conn->query($queryTipo1);
				$totalTipo1 = 0;
				if ($resultTipo1) {
				    $rowTipo1 = $resultTipo1->fetch_assoc();
				    $totalTipo1 = $rowTipo1["total_tipo_1"];
				}

				// Calcula o total da tabela tickets_saled onde o event_id é de um events.tipo = 2
				$queryTipo2 = "SELECT SUM(ts.valor) AS total_tipo_2 FROM tickets_saled ts
				               INNER JOIN events e ON ts.event_id = e.id
				               WHERE e.tipo = 2 AND ts.status = 1";
				$resultTipo2 = $conn->query($queryTipo2);
				$totalTipo2 = 0;
				if ($resultTipo2) {
				    $rowTipo2 = $resultTipo2->fetch_assoc();
				    $totalTipo2 = $rowTipo2["total_tipo_2"];
				}

				// Calcula a porcentagem de lucro com base em $config['lucro']
				$lucro = $config['lucro'];

				$lucroStatus1 = ($lucro / 100) * $totalStatus1;
				$lucroTipo1 = ($lucro / 100) * $totalTipo1;
				$lucroTipo2 = ($lucro / 100) * $totalTipo2;

				?>

				<div class="module">
					<canvas id="graficoLucro"></canvas>
				</div>

				<script>
				var ctx = document.getElementById('graficoLucro').getContext('2d');

				var data = {
				    labels: ['Lucro por Produtores', 'Lucro por Revenda'],
				    datasets: [{
				        label: 'Lucro R$',
				        data: [<?php echo $lucroTipo1 ?>, <?php echo $lucroTipo2 ?>],
				        backgroundColor: ['#AFA4CE', '#0C2140']
				    }]
				};

				var options = {
				    scales: {
				        y: {
				            beginAtZero: true
				        }
				    }
				};

				var myChart = new Chart(ctx, {
				    type: 'doughnut',
				    data: data,
				    options: options
				});
				</script>

			</div>
		</div>
	</div>
</body>
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bulma.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bulma.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.excel.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.pdfMake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function() {
    var minhaTabela = $('.table').DataTable({
        lengthChange: false,
        searching: true,
        language: {
            info: "_START_ a _END_ de _TOTAL_ registros",
            search: "Pesquisar:",
            searchPlaceholder: "Pesquise aqui...",
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs: [
            {
                targets: 5, // Índice da coluna (começando em 0)
                type: 'date', // Define o tipo de dados da coluna como 'date'
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Converte a data para o formato 'DD/MM/YYYY' usando moment.js
                        return moment(data, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    }
                    return data;
                }
            }
        ],
        order: [[5, 'asc']]
    });

    $('#aplicarFiltro').on('click', function() {
        var dataInicial = $('#dataInicial').val();
        var dataFinal = $('#dataFinal').val();
        minhaTabela.search(dataInicial + ' - ' + dataFinal).draw();
    });

    $('#limparFiltro').on('click', function() {
        $('#dataInicial').val('');
        $('#dataFinal').val('');
        minhaTabela.search('').draw();
    });
});f
</script>
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