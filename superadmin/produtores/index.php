<?php 

	$page_name = "Produtores";
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
										$query = "SELECT COUNT(*) AS total_registros FROM producer";
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
			<div class="module">
				<table class="table">
					<thead>
						<tr>
							<th style="text-align: left;" scope="col"></th>
							<th style="text-align: left;" scope="col">Nome</th>
							<th style="text-align: left;" scope="col">E-mail</th>
							<th style="text-align: center;" scope="col">CPF/CNPJ</th>
							<th style="text-align: center;" scope="col">Telefone</th>
							<th style="text-align: center;" scope="col">Cidade</th>
							<th style="text-align: center;" scope="col">Status</th>
							<th style="text-align: left;" scope="col"></th>
						</tr>
					</thead>
					<tbody>

						<?php // [Lancelot]: faz a listagem dos eventos do usuário
						$consulta = "SELECT * FROM producer ORDER BY name ASC";
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { ?>
						<tr>
						    <th class="align-middle" style="width: 7%; text-align: left">
						        <?php echo $dado['id']; ?>
						    </th>
						    <td class="align-middle" style="text-align: left">
						        <?php echo ucwords($dado['name'] . ' ' . $dado['surname']); ?>
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
						        <?php echo empty($dado['endereco_cidade'] AND $dado['endereco_estado']) ? '--' : $dado['endereco_cidade'] . ', ' . $dado['endereco_estado']; ?>
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