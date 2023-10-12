<?php 

	$page_name = 'Ticket'; 
	require "../config/conn.php";
	require "../config/geral.php";
	require "../config/cdn.php";

	// [Lancelot]: alterar para post
	$ticket_code = $_GET['ticket_code'];
	$query = "SELECT * FROM tickets_saled WHERE id = '$ticket_code'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($ticket_data = mysqli_fetch_array($mysqli_query)) { $ticket = $ticket_data; }

	function qrGenerator($data) {
		return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . $data;
	}

?>

<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">

<style>
	body {
		margin: 0px;
		background: #e0e0e0;
		font-family: Poppins !important;

	}
	div.ticket {
		font-size: 0.9rem !important;
		border-radius: 25px;
		padding: 40px;
		border-radius: 40px;
		background: #fff;
		box-shadow:  20px 20px 60px #bebebe,
		             -20px -20px 60px #ffffff;
	}
	div.alignContent {
		width: 80%;
		position: absolute;
		transform: translate3d(-50%, -50%, 0px);
		top: 45%;
		left: 50%;
	}
	.ticket_qrcode {
		position: relative;
		z-index: 2;
		width: 100%;
		padding: 15px;
		border-radius: 15px;
		box-shadow:  20px 20px 50px #bebebe50,
		             -20px 15px 50px #bebebe10;
	}
	.scan_me {
		z-index: 3;
		padding: 15px;
		border-radius: 15px;
		margin-top: 10px;
		position: relative;
		background: white;
		text-align: center;
		font-size: 0.8rem !important;
		font-weight: 500 !important;
		cursor: pointer;
		transition: all 300ms;
		box-shadow:  -20px 15px 50px #bebebe30;
	}
	.scan_me:hover {
		color: white;
		background: var(--primaria);
	}
	.scan_me svg {
		margin-right: 5px;
	}
	.logo {
		position: relative;
		z-index: 99;
		width: 100px;
	}
</style>

<div class="alignContent">
	<div class="ticket">
		<div class="row">
			<div class="col-sm">
				<div class="align">
					<p><?php echo $ticket['event_id']; ?></p>
				</div>
			</div>
			<div class="col-3">
				<div class="align">
					<img class="ticket_qrcode" src="<?php echo qrGenerator($ticket['qrcode']); ?>">
					<div class="scan_me">
						<i class="fa-regular fa-floppy-disk"></i>
						SALVAR INGRESSO
					</div>
				</div>
			</div>
		</div>
	</div>
</div>