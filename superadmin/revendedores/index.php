<?php 

	$page_name = "Revendedores";
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
								<i class="fa-solid fa-user-group iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros
													FROM users
													INNER JOIN events ON users.id = events.business_id
													WHERE events.tipo = 2;";
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Cadastros</label>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		</form>
		<div style="margin-top: 20px;" class="row">
			<div class="col-9">
				<h1 class="title">Revendedores:</h1>
				<div class="module">
					<table class="table">
						<thead>
							<tr>
								<th style="text-align: left;" scope="col"></th>
								<th style="text-align: left;" scope="col">Nome</th>
								<th style="text-align: left;" scope="col">E-mail</th>
								<th style="text-align: center;" scope="col">CPF</th>
								<th style="text-align: center;" scope="col">Telefone</th>
								<th style="text-align: center;" scope="col">Cidade</th>
								<th style="text-align: left;" scope="col"></th>
							</tr>
						</thead>
						<tbody>

							<?php // [Lancelot]: faz a listagem dos eventos do usuário
							$consulta = "SELECT users.*
										 FROM users
										 INNER JOIN events ON users.id = events.business_id
										 WHERE events.tipo = 2;";
							$con = $conn->query($consulta) or die($conn->error);
							while($dado = $con->fetch_array()) { ?>
							<tr>
							    <th class="align-middle" style="width: 7%; text-align: left">
							        <?php echo $dado['id']; ?>
							    </th>
							    <td class="align-middle" style="text-align: left">
							        <?php echo ucwords($dado['nome'] . ' ' . $dado['surname']); ?>
							    </td>
							    <td class="align-middle" style="text-align: left">
							        <?php echo empty($dado['email']) ? '--' : $dado['email']; ?>
							    </td>
							    <td class="align-middle" style="text-align: center">
							        <?php echo empty($dado['cpf_cnpj']) ? '--' : $dado['cpf_cnpj']; ?>
							    </td>
							    <td class="align-middle" style="width: 15%; text-align: center">
							        <?php echo empty($dado['telefone']) ? '--' : $dado['telefone']; ?>
							    </td>
							    <td class="align-middle" style="text-align: center">
							        <?php echo empty($dado['address_cidade'] AND $dado['address_estado']) ? '--' : $dado['address_cidade'] . ', ' . $dado['address_estado']; ?>
							    </td>
							    <td class="align-middle" style="width: 5%; text-align: right">
							    	<!-- <a target="_blank" href="<?php echo $config['app_local'] ?>/evento/?id=<?php echo $dado['id'] ?>"><i style="margin-left: 5px;" class="fa-regular fa-eye fa-sm"></i></a> -->
							    	<i onclick="return confirm('Certeza? Esta ação é irreversível.')" style="margin-left: 5px;" class="fa-regular fa-trash-can fa-sm"></i>
							    	<a href="#"><i style="margin-left: 5px;" class="fa-regular fa-eye fa-sm"></i></a>
							    </td>
							</tr>
							<?php } ?>


						</tbody>
					</table>
				</div>
			</div>
			<div class="col-3">
				<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
				<h1 class="title">Revendedores/Cadastros:</h1>
				
				<div class="module">
					<canvas id="graficoQntd"></canvas>
				</div>

				<script>
				var ctx = document.getElementById('graficoQntd').getContext('2d');

				<?php 

					$query = "SELECT COUNT(*) AS total_registros FROM producer WHERE vinculo_tipo = 'Admin'";
					$result = $conn->query($query);
					if ($result) {
					    $row = $result->fetch_assoc();
					    $produtores = $row["total_registros"];
					}

					$query = "SELECT COUNT(*) AS total_registros
								FROM users
								INNER JOIN events ON users.id = events.business_id
								WHERE events.tipo = 2;";
					$result = $conn->query($query);
					if ($result) {
					    $row = $result->fetch_assoc();
					    $revendedores = $row["total_registros"];
					}
				 
					$query = "SELECT COUNT(*) AS total_registros FROM users";
					$result = $conn->query($query);
					if ($result) {
					    $row = $result->fetch_assoc();
					    $compradores = $row["total_registros"];
					}

				?>

				var data = {
				    labels: ['Produtores', 'Revendedores', 'Compradores'],
				    datasets: [{
				        label: "Total: ",
				        data: [<?php echo $produtores ?>, <?php echo $revendedores ?>, <?php echo $compradores ?>],
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

<script>
$(document).ready(function() {
    $('.table').DataTable({
        lengthChange: true,
        searching: true,
        language: {
            info: "_START_ a _END_ de _TOTAL_ registros",
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
</html>