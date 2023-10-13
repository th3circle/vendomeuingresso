<?php 

	$page_name = 'Minha Conta';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (isset($_SESSION['user_consumer'])) {

		$id = $_SESSION['user_consumer']['id'];
		$query = "SELECT * FROM users WHERE id = '$id'";
		$mysqli_query = mysqli_query($conn, $query);
		while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

	} else {
		header('Location: ' . $config['app_local'] . '/login');
	}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick-theme.css">

	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/home.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/consumer/minha-conta.css">

</head>
<body>
<?php if (isMobileDevice()) { require "../../app/topbar_mobile.php"; } else { require "../../app/topbar.php"; } ?>

	<div style="margin-top: 100px;" class="container firtscontainer">
		<div style="margin-top: 20px;" class="row">
			<div class="col-11 col-lg-3 mx-auto">
				<div class="module profile_pp" style="background: url('<?php echo $config['app_local'] . '/assets/pp/consumer/' . $consumer['pp'] ?>');"	></div>
				<span id="clickUpdate"><i class="fa-regular fa-pen-to-square changePic"></i></span>
				<form action="" method="POST" enctype="multipart/form-data" id="formPP">
					<input type="file" name="pp" id="inputPP" style="display: none;">
				</form>
				<ul class="left_menu">
					<a href="<?php echo $config['app_local'] ?>/c/meus-ingressos"><li class=""><i class="fa-solid fa-ticket"></i> Meus Ingressos</li></a>
					<li><hr></li>
					<a href="<?php echo $config['app_local'] ?>/c/minha-conta"><li class="ative"><i class="fa-solid fa-circle-user"></i> Minha Conta</li></a>
					<a href="<?php echo $config['app_local'] ?>/c/revenda"><li><i class="fa-solid fa-shop fa-sm"></i> Revenda</li></a>
					<a href="<?php echo $config['app_local'] ?>/app/logout.php"><li><i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i> Sair</li></a>
				</ul>
			</div>
			<div class="col-12 col-lg-9">
				<?php if ($user['verify_email'] == false) { ?>
				<div <?php if (isset($cor)) { echo 'style="background: '.$cor.' !important;"'; } ?> class="alert_email">
					<div class="row">
						<div class="col-8 col-lg-10">
							<div style="font-size: 0.8rem !important;" class="align">
								<i class="fa-solid fa-bell"></i>
								<?php 

								if (isset($msg)) {
									echo $msg;
								} else {
									echo 'Atenção! Verifique o seu e-mail para concluir o processo de confirmação.';
								}

								?>
							</div>
						</div>
						<div style="text-align: right;" class="col-4 col-lg-2 resendDiv">
							<div class="align">
								<button <?php if (isset($_GET['sendMail'])) { echo 'style="opacity: 0 !Important; cursor: defaut !Important;"'; } else { echo 'onclick="window.location.href=`./verificar-email/resendMail.php`"'; } ?> class="resend">
									<i class="fa-regular fa-share-from-square"></i>
									Reenviar
								</button>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div style="padding: 25px 30px;" class="module">
					<div class="row">
						<div class="col-12">
							<h1 class="titleTickets"><i class="fa-regular fa-folder"></i> Meus Ingressos</h1>
						</div>
						<div class="col-12">

							<?php
							$consulta = "SELECT tickets_saled.*, events.title AS nome_evento, events.banner AS event_banner, events.city AS event_city, events.uf AS event_UF
							            FROM tickets_saled 
							            INNER JOIN events ON tickets_saled.event_id = events.id
							            WHERE user_id = '$id' AND events.status = 1 AND tickets_saled.status != 4
							            ORDER BY tickets_saled.id DESC;";
							$con = $conn->query($consulta) or die($conn->error);

							if ($con->num_rows == 0) {
							    echo "Não há registros";
							} else {
							    while ($dado = $con->fetch_array()) { ?>
							        <div class="row ticketBox">
							            <div class="col-12 col-lg-2">
							                <div style="background: url('<?php echo '../../attachments/eventos/capas/' . $dado['nome_evento'] . '_' . $dado['event_banner'] ?>');" class="capaEvent"></div>
							            </div>    
							            <div class="col-sm">
							                <div class="align">
							                    <label class="ticketName"><?php echo '#' . $dado['tk_code'] . ' - ' . $dado['nome_evento'] ?></label><br>
							                    <label class="local"><?php echo $dado['event_city'] . ', ' . $dado['event_UF']; ?></label>
							                </div>
							            </div>
							            <div style="text-align: right;" class="col-6 col-lg-1">
							                <label class="date align">
							                    <?php
							                        $parts = explode('|', $dado['ticket']);
							                        echo trim($parts[1]);
							                    ?>
							                </label>
							            </div>
							            <div style="text-align: center;" class="col-6 col-lg-2">
							                <div class="align">
							                    <?php 
							                        if ($dado['status'] == 0) { $status = 'AGUARDANDO PAG.'; }
							                        elseif ($dado['status'] == 1) { $status = 'PAGO'; }
							                        elseif ($dado['status'] == 2) { $status = 'RECUSADO'; }
							                        else { $status = 'ERRO'; }
							                    ?>
							                    <label class="status status_<?php echo $dado['status'] ?>"><?php echo $status ?></label><br>
							                </div>
							            </div>
							            <div class="col-12 col-lg-2">
							            	<?php if ($dado['status'] == 1) { ?>
							                <div class="align">
							                    <form target="_blank" method="POST" action="<?php echo $config['app_local'] ?>/c/ticket/">
							                        <input type="hidden" name="id" value="<?php echo $dado['id']; ?>">
							                        <button style="width: 100%; margin: 0; font-size: 0.7rem;" class="my_tickets borderButton">Detalhes</button>
							                    </form>
							                </div>
							            	<?php } ?>
							            </div>
							        </div>
							    <?php }
								}
							?>

						</div>
					</div>
					<div style="margin-top: 80px;" class="row">
						<div class="col-12">
							<h1 class="titleTickets"><i class="fa-regular fa-folder"></i> Ingressos encerrados</h1>
						</div>
						<div class="col-12">

							<?php
							$consulta = "SELECT tickets_saled.*, events.title AS nome_evento, events.banner AS event_banner, events.city AS event_city, events.uf AS event_UF
							            FROM tickets_saled 
							            INNER JOIN events ON tickets_saled.event_id = events.id
							            WHERE user_id = '$id' AND tickets_saled.status = 1 AND events.status != 1
							            GROUP BY tickets_saled.tk_code;";
							$con = $conn->query($consulta) or die($conn->error);

							if ($con->num_rows == 0) {
							    echo "<p class='nothing'>Nada de novo por aqui!</p>";
							} else {
							    while ($dado = $con->fetch_array()) { ?>
							        <div style="filter: saturate(0%);" class="row ticketBox">
							            <div class="col-12 col-lg-2">
							                <div style="opacity: 0.5; background: url('<?php echo '../../attachments/eventos/capas/' . $dado['nome_evento'] . '_' . $dado['event_banner'] ?>');" class="capaEvent"></div>
							            </div>    
							            <div class="col-sm">
							                <div class="align">
							                    <label class="ticketName"><?php echo '#' . $dado['tk_code'] . ' - ' . $dado['nome_evento'] ?></label><br>
							                    <label class="local"><?php echo $dado['event_city'] . ', ' . $dado['event_UF']; ?></label>
							                </div>
							            </div>
							            <div class="col-6 col-lg-1">
							                <label class="date align">
							                    <?php
							                        $parts = explode('|', $dado['ticket']);
							                        echo trim($parts[1]);
							                    ?>
							                </label>
							            </div>
							            <div style="text-align: center;" class="col-6 col-lg-2">
							                <div class="align">
							                    <?php 
							                        if ($dado['status'] == 0) { $status = 'PROC. PAGAMENTO'; }
							                        elseif ($dado['status'] == 1) { $status = 'PAGO'; }
							                        elseif ($dado['status'] == 2) { $status = 'RECUSADO'; }
							                        else { $status = 'ERRO'; }
							                    ?>
							                    <label class="status status_<?php echo $dado['status'] ?>"><?php echo $status ?></label><br>
							                </div>
							            </div>
							        </div>
							    <?php }
								}
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php require "../../app/footer.php"; ?>
</body>
</html>