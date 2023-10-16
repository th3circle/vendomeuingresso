<?php 

	$page_name = "Gerenciar Saques";
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
								<th class="left">Produtor</th>
								<th class="left">Valor</th>
								<th class="left">Data</th>
								<th class="right"></th>
							</tr>
						</thead>
						<tbody>
						<?php // [Lancelot]: faz a listagem dos eventos do usuário
						$consulta = "SELECT * FROM withdrawals WHERE status = 0 ORDER BY data ASC";
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { ?>
						<tr>
						    <th class="align-middle left"><?php echo $dado['id']; ?></th>
						    <td class="align-middle left"><?php echo $dado['produtor']; ?></td>
						    <td class="align-middle center"><?php echo 'R$ ' . number_format($dado['valor'], 2,',','.'); ?></td>
						    <td class="align-middle center"><?php echo $dado['data']; ?></td>
						    <td class="align-middle" style="text-align: right !important;">
						    	<a target="_blank" href="./aprovar.php?id=<?php echo $dado['id'] ?>"><i style="margin-right: 5px; color: #00000080;" class="fa-solid fa-user"></i></a>
								<a onclick="return confirm('Marque esta opção apenas quando a transferência for efetuada.')" target="_blank" href="../produtores/ver/?id=<?php echo $dado['id'] ?>"><i style="margin-right: 5px; color: #00000080;" class="fa-solid fa-circle-check"></i></a>
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
                targets: 3, // Índice da coluna (começando em 0)
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
        order: [[3, 'asc']]
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