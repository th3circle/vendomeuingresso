<?php 

	$page_name = 'Home';

	require "../config/conn.php";
	require "../config/geral.php";
	require "../config/cdn.php";

	require "../config/functions/app.php";
	require "../config/functions/auth.php";
	require "../config/functions/user.php";

	$category_id = $_GET['id'];
	$query = "SELECT * FROM categories WHERE id = '$category_id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($categoria_data = mysqli_fetch_array($mysqli_query)) { $categoria = $categoria_data; }

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/home.css">

</head>
<body>
<?php if (isMobileDevice()) { require "../app/topbar_mobile.php"; } else { require "../app/topbar.php"; } ?>

	<div  class="bannerCategoria">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php echo strtoupper($categoria['nome']); ?></h1>
				</div>
			</div>
		</div>
	</div>

	<!-- [Bediwere]: listagem do evento -->
	<section style="margin-bottom: 70px;" id="tickets" class="mt-75">
		<div class="container">

			<div style="margin-top: 20px;" class="row dropEvents">
				<?php $consulta = "SELECT * FROM events WHERE status != 0 AND categoria = '$category_id' ORDER BY event_data DESC LIMIT 12";
				$con = $conn->query($consulta) or die($conn->error);
				if ($con->num_rows > 0) {
				while($dado = $con->fetch_array()) { ?>
				<div class="col-11 col-md-4 col-lg-3 mx-auto">
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
						<div class="col-3 col-lg-1">
							<i class="fa-solid fa-ticket"></i>
						</div>
						<div class="col-9 col-lg-sm">
							<div class="align">
								<h1 class="title_section">Perto de Você</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end title -->

			<div style="margin-top: 20px;" class="row dropEvents">
				<?php $uf = isset($_SESSION['location']->uf) ? $_SESSION['location']->uf : 'NA'; $consulta = "SELECT * FROM events WHERE status != 0 AND uf = '$uf' AND categoria = '$category_id' ORDER BY event_data DESC LIMIT 12";
				$con = $conn->query($consulta) or die($conn->error);
				if ($con->num_rows > 0) {
				while($dado = $con->fetch_array()) { ?>
				<div class="col-11 col-md-4 col-lg-3 mx-auto">
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
				<?php } } else { echo "<center><p class='nothing'> Nenhum evento encontrado! Veja eventos um pouco mais distantes: <br><br> <a href='../eventos'><button style='width: 100px;' class='my_tickets'>Ver Tudo</button></a></p></center>"; } ?>
			</div>
		</div>
	</section>

<?php require "../app/footer.php"; ?>
</body>
</html>