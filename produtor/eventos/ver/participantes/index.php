<?php 

	$page_name = "Lista de Convidados";
	require "../../../../config/conn.php";
	require "../../../../config/geral.php";
	require "../../../../config/cdn.php";
	require "../../../app/producer_vars.php";

	require "../../../../vendor/autoload.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$id = $producer['id'];
	$id_event = $_GET['id'];

	$query = "SELECT * FROM events WHERE id = '$id_event' AND business_id = '$id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($evento_data = mysqli_fetch_array($mysqli_query)) { $evento = $evento_data; }

	if (isset($_POST['nome']) && isset($_POST['email'])) {

	    $nome_completo = explode(" ", $_POST['nome']);
	    $nome_c = $_POST['nome'];
	    $nome = $nome_completo[0];
	    $sobrenome = implode(" ", array_slice($nome_completo, 1));
	    $email = $_POST['email'];

	    echo $_POST['ingresso'];

		$postTicket = json_decode($_POST['ingresso'], true);

		$ticket_name		= $postTicket['tipo'] . ': ' . $evento['title'];
		$tk_code			= rand(000001,999999);
		$ticket_data		= $postTicket['data'];

	    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
	    $checkResult = $conn->query($checkQuery);

	    if ($checkResult->num_rows > 0) {

	        $query = "INSERT INTO convidados (nome, email, event_id, ticket, tk_code, ticket_date) VALUES ('$nome_c', '$email', '$id_event', '$ticket_name', '$tk_code', '$ticket_data')";

	        if ($conn->query($query) === TRUE) {

	            $mail = new PHPMailer(true);

	            try {
	            	
	                $mail->isSMTP();
	                $mail->Host       = $config['smtp_host'];
	                $mail->SMTPAuth   = true;
	                $mail->Username   = $config['smtp_user'];
	                $mail->Password   = $config['smtp_pass'];
	                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	                $mail->Port       = $config['smtp_port'];

	                $mail->setFrom($config['smtp_user'], $config['app_name']);
	                $mail->addAddress($email, $_POST['nome']);

	                $mail->isHTML(true);
	                $mail->Subject = utf8_decode($config['app_name'] . ': Olá ' . $nome . ', você foi convidado(a) para o evento ' . $evento['title']);
	    			$mail->Body = 'O seu ingresso já foi enviado via anexo neste e-mail, para saber mais, acesse: www.vendomeuingresso.com/convidado.';

	                $mail->send();
	                echo '<script>window.location.href="./?id='.$id_event.'"</script>';

	            } catch (Exception $e) {
	                echo '<script>alert("Erro no envio de email. Contacte o suporte.");window.location.href="./?id='.$id_event.'"</script>';
	            }

	        } else {
	            echo '<script>alert("Erro: #3192NDKQR | Erro ao inserir! Contacte o suporte.");window.location.href="./?id='.$id_event.'"</script>';
	        }

	    } else {

	        $query = "INSERT INTO convidados (nome, email, event_id, ticket, tk_code, ticket_date) VALUES ('$nome_c', '$email', '$id_event', '$ticket_name', '$tk_code', '$ticket_data')";

	        if ($conn->query($query) === TRUE) {

	            $mail = new PHPMailer(true);

	            try {
	            	
	                $mail->isSMTP();
	                $mail->Host       = $config['smtp_host'];
	                $mail->SMTPAuth   = true;
	                $mail->Username   = $config['smtp_user'];
	                $mail->Password   = $config['smtp_pass'];
	                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	                $mail->Port       = $config['smtp_port'];

	                $mail->setFrom($config['smtp_user'], $config['app_name']);
	                $mail->addAddress($email, $_POST['nome']);

	                $mail->isHTML(true);
	                $mail->Subject = utf8_decode($config['app_name'] . ': Olá ' . $nome . ', você foi convidado(a) para o evento ' . $evento['title']);
	    			$mail->Body = 'O seu ingresso já foi enviado via anexo neste e-mail, para saber mais, acesse: www.vendomeuingresso.com/convidado.';

	                $mail->send();
	                echo '<script>window.location.href="./?id='.$id_event.'"</script>';

	            } catch (Exception $e) {
	                echo '<script>alert("Erro no envio de email. Contacte o suporte.");window.location.href="./?id='.$id_event.'"</script>';
	            }

	        } else {
	            echo '<script>alert("Erro: #3192NDKQR | Erro ao inserir! Contacte o suporte.");window.location.href="./?id='.$id_event.'"</script>';
	        }
	    }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../../../assets/css/produtor/ajustes.css">
	<link rel="stylesheet" type="text/css" href="../../../../assets/css/produtor/evento.css">
</head>
<body>
	<?php require "../../../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div class="row">
			<div style="margin-bottom: 20px;" class="col-12">
				<a style="text-decoration: none; color: #00000090; font-size: 0.8rem !important;" href="../?id=<?php echo $id_event ?>">< Voltar</a>
			</div>
			<div class="col-9">
				<div style="margin-bottom: 35px;" class="row">

					<div class="col-sm">
						<div class="align">
							<h5 style="margin: 0px !important;" class="title_module">Convidados: <?php echo $evento['title'] ?></h5>
						</div>
					</div>

					<div style="text-align: right;" class="col-sm">
						<div class="align">
							<button onclick="exportToCSV('guests_export')" class="act_event">
								<i class="fa-solid fa-download fa-sm"></i>
								Salvar
							</button>
						</div>
					</div>

				</div>
				<div class="row">
					<div style="margin-bottom: 20px;" class="col-12">
						<form method="POST" action="" id="newUser">
							<div class="row">
								<div class="col-4">
									<label class="input">Nome Completo: <b class="req">*</b></label>
									<input required type="text" name="nome">
								</div>
								<div class="col-3">
									<label class="input">Ingresso:</label>
									<select required name="ingresso">
										<?php
										$ingressos = json_decode($evento['ingressos'], true);
										foreach ($ingressos AS $data => $ingresso) { $tipo = $ingresso['tipo']; ?>
										<option value='{"data": "<?php echo $data ?>", "tipo": "<?php echo $tipo ?>"}'><?php echo date('d/m/Y', strtotime($data)) . ' - ' . $ingresso['tipo'] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-3">
									<label class="input">E-mail: <b class="req">*</b></label>
									<input required type="email" name="email">
								</div>
								<div class="col-2">
									<button form="newUser" style="font-size: 0.8rem !important; bottom: 0px !important; margin: 0px !important; top: 8px; padding: 11px 15px !important;" class="act"><i class="fa-solid fa-plus"></i> Adicionar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="module">
					<div class="row">
						<div class="col-12">
							<table id="guests_export" class="table">
								<thead>
									<tr>
										<th class="left">Nome</th>
										<th class="left">Ingresso</th>
										<th class="left">E-mail</th>
										<th class="center">Data</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$consulta = "SELECT * FROM convidados WHERE event_id = '$id_event'";
								$con = $conn->query($consulta) or die($conn->error);

								if ($con->num_rows == 0) {
								    echo "<td class='nothing' colspan='4'>Nada por aqui...</td>";
								} else { while($dado = $con->fetch_array()) { ?>
						        <tr>
						            <td class="left"><?php echo $dado['nome']; ?></td>
						            <td class="left"><?php echo $dado['ticket'] ?></td>
						            <td class="left"><?php echo $dado['email'] ?></td>
						            <td class="center"><?php echo date('d/m/Y', strtotime($dado['ticket_date'])) ?></td>
						        </tr>
						        <?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3">
				<div class="module tip">
					<label class="titleTip">
						<i class="fa-solid fa-circle-info"></i>
						Atenção!
					</label>
					<p class="descTip">
						Após o cadastro o usuário receberá uma notificação por e-mail com instruções detalhadas sobre como criar sua conta, caso ainda não tenha uma. Uma vez que a conta tenha sido criada com sucesso, o ingresso enviado será automaticamente incorporado ao menu 'Meus Ingressos', onde estará disponível para acesso e gerenciamento.
						<br>
						<br>
						Tenha cuidado, uma vez enviado ao convidado, o ingresso não poderá ser recuperado, portanto, recomendamos que esteja atento durante todo o processo.
					</p>
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
function confirmAlert(msg, link) {
    var resposta = confirm(msg);
    if (resposta === true) {
        window.location.href = link;
    }
}
</script>
</html>