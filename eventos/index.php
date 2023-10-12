<?php 

	$page_name = 'Eventos';

	require "../config/conn.php";
	require "../config/geral.php";
	require "../config/cdn.php";

	require "../config/functions/app.php";
	require "../config/functions/auth.php";
	require "../config/functions/user.php";

	$filter = "";

	if (isset($_GET['categoria'])) {
		if ($_GET['categoria'] == 'Todas') {

			$filter = "AND event_data = '" . $_GET['data'] . "'";

		} else {

			$filter = "AND categoria = '" . $_GET['categoria'] . "' AND event_data = '" . $_GET['data'] . "'";

		}
	}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/consumer/minha-conta.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/home.css">

</head>
<body>
<?php if (isMobileDevice()) {  } else { require "../app/topbar.php"; } ?>

	<div class="container">
		<form method="GET" action="" id="filter">
			<div style="margin-top: 75px;" class="row">
				<div class="col-sm">

				</div>
				<div class="col-2">
					<label class="input">Categorias: <b class="req">*</b></label>
					<select name="categoria">
						<option>Todas</option>
						<?php // [Lancelot]: faz a listagem das categeorias marcadas como destaque e na ordem selecionada
						$consulta = "SELECT * FROM categories WHERE status != 0 ORDER BY posicao ASC";
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { $id_cat = $dado['id']; ?>
						<option value="<?php echo $dado['id'] ?>"><?php echo $dado['nome'] ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-2">
					<label class="input">Data: <b class="req">*</b></label>
					<?php
					$today = date('Y-m-d');
					$thisMonthStart = date('Y-m-01');
					$thisMonthEnd = date('Y-m-t', strtotime($thisMonthStart));
					$tomorrow = date('Y-m-d', strtotime('+1 day'));
					$thisWeekStart = date('Y-m-d', strtotime('last Sunday'));
					$thisWeekEnd = date('Y-m-d', strtotime('this Saturday'));
					$nextWeekStart = date('Y-m-d', strtotime('next Sunday'));
					$nextWeekEnd = date('Y-m-d', strtotime('next Saturday'));

					echo '<select name="data">';
					echo '<option value="' . $thisMonthStart . '~' . $thisMonthEnd . '">Este mês</option>';
					echo '<option value="' . $today . '">Hoje</option>';
					echo '<option value="' . $tomorrow . '">Amanhã</option>';
					echo '<option value="' . $thisWeekStart . '~' . $thisWeekEnd . '">Esta semana</option>';
					echo '<option value="' . $thisWeekEnd . '~' . $nextWeekEnd . '">Este fim de semana</option>';
					echo '<option value="' . $nextWeekStart . '~' . $nextWeekEnd . '">Próxima semana</option>';
					// Adicione outras opções conforme necessário
					echo '</select>';
					?>

				</div>
				<div class="col-1">
					<div class="align">
						<button form="filter" style="padding: 13px 15px; margin-top: 8px;" class="my_tickets"><i class="fa-solid fa-filter"></i></button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<!-- [Bediwere]: listagem do evento -->
	<section style="margin-bottom: 70px; margin-top: 30px;" id="tickets">
		<div class="container">

			<div style="margin-top: 20px;" class="row dropEvents">
				<?php $consulta = "SELECT * FROM events WHERE status != 0 ".$filter." ORDER BY event_data DESC LIMIT 12";
				$con = $conn->query($consulta) or die($conn->error);
				if ($con->num_rows > 0) {
				while($dado = $con->fetch_array()) { ?>
				<div class="col-11 col-md-4 col-lg-3">
					<div onclick="window.location.href='<?php echo $config['app_local'] ?>/evento/?id=<?php echo $dado['id']; ?>'" class="moduleEvent">
						<label class="tag_type <?php if ($dado['tipo'] == 2) { echo 'tagtype_revenda'; } ?>">
							<?php if ($dado['tipo'] == 2) { echo 'REVENDA'; } else { echo 'PRODUTOR'; } ?>
						</label>
						<div
						 <?php if (isset($dado['photo']) AND !empty($dado['photo'])) { ?>
						 style="background: url('../attachments/eventos/photos/<?php echo $dado['photo']; ?>');"
						 <?php } else { ?>
						 style="background: url('../attachments/eventos/capas/<?php if ($dado['tipo'] == 2) {echo str_replace('REVENDA: ', '', $dado['title']) . '_' . $dado['banner'];} else {echo $dado['title'] . '_' . $dado['banner'];} ?>');"
						 <?php } ?>
						 class="photo"></div>
						<div style="padding: 0px 8px;" class="row">
							<div class="col-9">
								<label class="title"><?php echo $dado['title']; ?></label><br>
								<label class="city"><?php echo $dado['city'] ?>, <?php echo $dado['uf']; ?></label><br>
								<button class="buy"><i class="fa-solid fa-brazilian-real-sign"></i>  Comprar</button>
							</div>
							<div style="text-align: right;" class="col-3">
								<center>
									<?php 
									$event_date = $dado['event_data'];
									$event_date_formatted = new DateTime($event_date);
									$event_date_formatted->setTimezone(new DateTimeZone('America/Sao_Paulo'));

									$monthNames = [
									    'January' => 'JAN',
									    'February' => 'FEV',
									    'March' => 'MAR',
									    'April' => 'ABR',
									    'May' => 'MAI',
									    'June' => 'JUN',
									    'July' => 'JUL',
									    'August' => 'AGO',
									    'September' => 'SET',
									    'October' => 'OUT',
									    'November' => 'NOV',
									    'December' => 'DEZ'
									];

									$month = $monthNames[$event_date_formatted->format('F')];
									$day = $event_date_formatted->format('d');
									$hour = $event_date_formatted->format('H:i'); 
									?>
									<label class="month"><?php echo $month; ?></label><br>
									<label class="day"><?php echo $day; ?></label><br>
									<label class="hour"><?php echo $hour; ?></label>
								</center>
							</div>
						</div>
					</div>
				</div>
				<?php } } else { echo "<p class='nothing'> Nenhum evento encontrado!</p>"; } ?>
			</div>
		</div>
	</section>

	<!-- [Bediwere]: listagem de eventos perto da localização -->
	<section style="margin-bottom: 70px;" id="tickets" class="mt-75">
		<div class="container">

			<!-- title -->
			<div class="row">
				<div class="col-sm">
					<div class="row title_section">
						<div class="col-1">
							<i class="fa-solid fa-ticket"></i>
						</div>
						<div class="col-sm">
							<div class="align">
								<h1 class="title_section">Perto de Você</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end title -->

			<div style="margin-top: 20px;" class="row dropEvents">
				<?php $uf = isset($_SESSION['location']->uf) ? $_SESSION['location']->uf : 'NA'; $consulta = "SELECT * FROM events WHERE status != 0 AND uf = '$uf' ORDER BY event_data DESC LIMIT 12";
				$con = $conn->query($consulta) or die($conn->error);
				if ($con->num_rows > 0) {
				while($dado = $con->fetch_array()) { ?>
				<div class="col-11 col-md-4 col-lg-3">
					<div onclick="window.location.href='<?php echo $config['app_local'] ?>/evento/?id=<?php echo $dado['id']; ?>'" class="moduleEvent">
						<label class="tag_type <?php if ($dado['tipo'] == 2) { echo 'tagtype_revenda'; } ?>">
							<?php if ($dado['tipo'] == 2) { echo 'REVENDA'; } else { echo 'PRODUTOR'; } ?>
						</label>
						<div
						 <?php if (isset($dado['photo']) AND !empty($dado['photo'])) { ?>
						 style="background: url('../attachments/eventos/photos/<?php echo $dado['photo']; ?>');"
						 <?php } else { ?>
						 style="background: url('../attachments/eventos/capas/<?php echo $dado['title'] . '_' . $dado['banner']; ?>');"
						 <?php } ?>
						 class="photo"></div>
						<div style="padding: 0px 8px;" class="row">
							<div class="col-9">
								<label class="title"><?php echo $dado['title']; ?></label><br>
								<label class="city"><?php echo $dado['city'] ?>, <?php echo $dado['uf']; ?></label><br>
								<button class="buy"><i class="fa-solid fa-brazilian-real-sign"></i>  Comprar</button>
							</div>
							<div style="text-align: right;" class="col-3">
								<center>
									<?php 
									$event_date = $dado['event_data'];
									$event_date_formatted = new DateTime($event_date);
									$event_date_formatted->setTimezone(new DateTimeZone('America/Sao_Paulo'));

									$monthNames = [
									    'January' => 'JAN',
									    'February' => 'FEV',
									    'March' => 'MAR',
									    'April' => 'ABR',
									    'May' => 'MAI',
									    'June' => 'JUN',
									    'July' => 'JUL',
									    'August' => 'AGO',
									    'September' => 'SET',
									    'October' => 'OUT',
									    'November' => 'NOV',
									    'December' => 'DEZ'
									];

									$month = $monthNames[$event_date_formatted->format('F')];
									$day = $event_date_formatted->format('d');
									$hour = $event_date_formatted->format('H:i'); 
									?>
									<label class="month"><?php echo $month; ?></label><br>
									<label class="day"><?php echo $day; ?></label><br>
									<label class="hour"><?php echo $hour; ?></label>
								</center>
							</div>
						</div>
					</div>
				</div>
				<?php } } else { echo "<center><p class='nothing'> Nenhum evento encontrado! Veja eventos um pouco mais distantes: <br><br> <a href='./eventos'><button style='width: 100px;' class='my_tickets'>Ver Tudo</button></a></p></center>"; } ?>
			</div>
		</div>
	</section>

<?php require "../app/footer.php"; ?>
</body>
</html>