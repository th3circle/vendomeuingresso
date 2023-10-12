<?php 

	$page_name = 'Ingresso';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";

	if (isset($_SESSION['user_consumer'])) {

		$id = $_SESSION['user_consumer']['id'];
		$query = "SELECT * FROM users WHERE id = '$id'";
		$mysqli_query = mysqli_query($conn, $query);
		while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

	} else {

		header('Location: ' . $config['app_local'] . '/login');

	}

	function qrCode($code) {
		$encodedText = urlencode($code);
		$qrCodeURL = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$encodedText";
		return $qrCodeURL;
	}

	$user_id 		= $_SESSION['user_consumer']['id'];
	$ticket_id 		= $_POST['id'];

	// user
	$query = "SELECT * FROM users WHERE id = '$user_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

	// ticket
	$query = "SELECT * FROM tickets_saled WHERE id = '$ticket_id' AND status = 1 AND user_id = '$user_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($ticket_data = mysqli_fetch_array($mysqli_query)) { $ticket = $ticket_data; }

	// event
	$event_id = $ticket['event_id'];
	$query = "SELECT * FROM events WHERE id = '$event_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($event_data = mysqli_fetch_array($mysqli_query)) { $event = $event_data; }

	if (isset($_POST['transferEmail'])) {

		if ($ticket['qntd'] == 1) {

	        $query = "UPDATE tickets_saled SET status = 4 WHERE id = '$ticket_id'";
	        $conn->query($query);

	        echo "
				<script>
				fetch('lib/mail_transferencia.php', {
				    method: 'POST',
				    body: JSON.stringify({ id_ticket: '".$ticket_id."' }),
				    headers: {
				        'Content-Type': 'application/json'
				    }
				})
				console.error('passou');
				</script>
	        ";

		} else {

	        $query = "UPDATE tickets_saled SET qntd = qntd - 1 WHERE id = '$ticket_id'";
	        $conn->query($query);

	        echo "
				<script>
				fetch('lib/mail_transferencia.php', {
				    method: 'POST',
				    body: JSON.stringify({ id_ticket: '".$ticket_id."' }),
				    headers: {
				        'Content-Type': 'application/json'
				    }
				})
				console.error('passou');
				alert('Sucesso! O ingresso foi enviado.');
				window.location.href='../meus-ingressos';
				</script>
	        ";

		}

	}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="../../assets/css/consumer/minha-conta.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/consumer/ticket.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">

</head>
<body style="padding-bottom: 100px;">
	<div style="margin-top: 7rem;" class="container">
		<div style="background: url('http://localhost/vendomeuingresso/attachments/eventos/capas/Rock%20Festival%20Nova%20Igua%c3%a7u_Frame%201%20(2).png');" class="capa"></div>
		<?php for ($i = 0; $i < $ticket['qntd']; $i++) { ?>
		<?php $qrcode = $ticket['tk_code'] . $i . $ticket['qrcode']; ?>
		<div id="ticketBox_<?php echo $i; ?>" class="row">
			<div class="col-12 col-lg-12 mx-auto">
				<div style="margin-top: 25px;" class="module">
					<div class="row">
						<div class="col-4 col-lg-2">
							<img oncontextmenu="return false;" class="qrCode" src="<?php echo qrCode($qrcode); ?>">
						</div>
						<div class="col-8 col-lg-5">
							<div class="align">
								<label class="evento"><?php echo $event['title'] ?></label><br>
								<label class="titular"><?php echo $user['nome'] . ' ' . $user['surname']; ?></label><br>
								<label class="local"><?php echo $event['city'] . ', ' . $event['uf'] . ' - ' . $event['local']; ?></label><br>
								<button onclick="printDiv('ticketBox_<?php echo $i; ?>')" style="margin-top: 15px;" class="my_tickets hiddenPrint">
									<i style="margin-right: 5px;" class="fa-solid fa-print"></i>
									IMPRIMIR INGRESSO
								</button>
								<button data-bs-toggle="modal" data-bs-target="#transferir_<?php echo $i ?>" class="my_tickets hiddenPrint borderButton">
									<i style="margin-right: 5px;" class="fa-solid fa-up-right-from-square fa-sm"></i>
									TRANSFERIR
								</button>
								<button form="revender" class="my_tickets hiddenPrint borderButton">
									<i style="margin-right: 5px;" class="fa-solid fa-shop fa-sm"></i>
									REVENDER
								</button>
							</div>
						</div>
						<div class="col-12 col-lg-5 mx-auto">
							<div class="align mobilePadding">
								<label class="codigo">#<?php echo $qrcode; ?></label><br>
								<label class="setor">Setor: <?php echo $ticket['tipo'] ?></label><br>
								<label class="setor">Data: <?php echo substr($ticket['ticket'], -10) ?></label><br>
								<img oncontextmenu="return false;" class="barcode" src="<?php echo barcode($qrcode); ?>">
							</div>
						</div>
						<div style="margin-top: 20px; padding-bottom: 20px;" class="col-12 col-lg-12">
							<div class="align">
								<p>Para garantir a segurança e a validade de seu ingresso, é imprescindível a apresentação de um documento original com foto no momento da entrada ao evento. O nome no ingresso deve corresponder ao nome no documento.</p>
								<p>Para ingressos de meia-entrada ou um ingresso que requer comprovação de meia-entrada, lembre-se de trazer também o documento que comprove sua elegibilidade para o benefício da meia-entrada. Isso pode incluir a carteira de estudante, a carteira de identidade (RG), a carteira de motorista (CNH) ou qualquer outro documento oficial que comprove sua condição de estudante, idoso ou outro beneficiário de meia-entrada.</p>
								<p>A falta de documentação adequada poderá impedir seu acesso ao evento. Certifique-se de trazer consigo todos os documentos necessários para evitar qualquer inconveniente.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form method="POST" target="_blank" id="revender" action="../../revender/" style="display: none;">
			<input type="text" name="revendaTrue" value="<?php echo $ticket_id; ?>">
		</form>

		<!-- Modal -->
		<div class="modal fade" id="transferir_<?php echo $i ?>" tabindex="-1" aria-labelledby="transferir_<?php echo $i ?>Label" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-body">
		      	<label style="margin-bottom: 10px; font-size: 1.6rem !important;" class="evento">Transferir: #<?php echo $qrcode; ?></label>
		      	<p class="descTransfer">Transferir seu ingresso para outra pessoa é um processo fácil e conveniente. Tudo o que você precisa fazer é inserir o endereço de e-mail da pessoa destinatária abaixo e, em seguida, clicar no botão 'Transferir'. Após essa etapa, a pessoa escolhida receberá um e-mail notificando-a da transferência e incluindo detalhadas instruções sobre como criar uma conta e resgatar o ingresso. É importante lembrar que, uma vez que o ingresso tenha sido transferido, ele não poderá ser revertido para sua posse, portanto, esteja certo de sua escolha antes de prosseguir com o processo.</p>
		      	<form method="POST" id="formTransfer_<?php echo $id ?>">
		      		<input type="hidden" name="id" value="<?php echo $ticket_id; ?>">
		      		<label class="input">E-mail:</label>
		      		<input required type="email" name="transferEmail">
		      	</form>
	      		<div class="ticketButton">
	        		<button style="margin-right: 15px !important;" type="button" data-bs-dismiss="modal" class="my_tickets borderButton">CANCELAR</button>
	        		<button onclick="return confirm('Tenha certeza, esta ação é irreversível!')" form="formTransfer_<?php echo $id ?>" class="my_tickets">TRANSFERIR</button>
	      		</div>
		      </div>
		    </div>
		  </div>
		</div>
		<?php } ?>
	</div>
</body>
<script>
function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
</html>