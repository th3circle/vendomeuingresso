<?php 

	$page_name = 'Home';

	require "config/conn.php";
	require "config/geral.php";
	require "config/cdn.php";

	require "config/functions/app.php";
	require "config/functions/auth.php";
	require "config/functions/user.php";

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

	<link rel="stylesheet" type="text/css" href="assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="assets/css/home.css">

</head>
<body>
<?php if (isMobileDevice()) {  } else { require "app/topbar.php"; } ?>

	<!-- [Lancelot]: listagem das categorias -->
	<section id="categories_slide" class="mt-50">
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
								<h1 class="title_section">Categorias</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end title -->

			<div style="margin-top: 50px;" class="row">
				<div class="col-12">
					<div class="categories_slide">
						<?php // [Lancelot]: faz a listagem das categeorias marcadas como destaque e na ordem selecionada
						$consulta = "SELECT * FROM categories WHERE destaque = 'true' AND status != 0 ORDER BY posicao ASC LIMIT " . $config['limite_categorias'];
						$con = $conn->query($consulta) or die($conn->error);
						while($dado = $con->fetch_array()) { $id_cat = $dado['id']; ?>
						<div onclick="window.location.href='./categoria?id=<?php echo $id_cat ?>'" style="text-align: center;	margin-right: 30px; height: auto !important;" class="category_box">
							<center>
								<div onclick="submitCategory(<?php echo $dado['id']; ?>);" class="category_item_banner">
									<div class="align category_item">
										<i class="<?php echo $dado['icone']; ?> fa-sm"></i><br>
									</div>
								</div>
								<label><?php echo $dado['nome']; ?></label>
							</center>
						</div>
						<?php } ?>
					</div>
					<script>
					  $('.categories_slide').slick({
					      dots: false,
					      infinite: true,
					      speed: 1000,
					      autoplay: true,
					      autoplaySpeed: 3000,
					      slidesToShow: 7,
					      slidesToScroll: 7,
					  });
					</script>
				</div>
			</div>
		</div>
	</section>

	<!-- [Bediwere]: listagem do evento -->
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
								<h1 class="title_section">Eventos</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end title -->

			<div style="margin-top: 20px;" class="row dropEvents">
				<?php $consulta = "SELECT * FROM events WHERE status != 0 ORDER BY event_data ASC LIMIT 12";
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
						 style="background: url('attachments/eventos/photos/<?php echo $dado['photo']; ?>');"
						 <?php } else { ?>
						 style="background: url('attachments/eventos/capas/<?php if ($dado['tipo'] == 2) {echo str_replace('REVENDA: ', '', $dado['title']) . '_' . $dado['banner'];} else {echo $dado['title'] . '_' . $dado['banner'];} ?>');"
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

	<?php // [Lancelot]: Configuração dos banners
	$banner_home = json_decode($config['banner_home'], true);
	if ($banner_home['config']['ativo'] == true) { ?>
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
							<h1 class="title_section">Eventos</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end title -->

		<div style="margin-top: 25px;" class="row">
			<div class="col-12">
				<div id="BannerHome" class="carousel slide" data-bs-ride="carousel">
				    <div style="border-radius: 15px; height: <?php echo $banner_home['config']['height'] ?>;" class="carousel-inner">
				        <?php foreach ($banner_home['banners'] as $i => $banner) { ?>
				            <div class="carousel-item <?php if ($i == 1) { echo 'active'; } ?>" data-bs-interval="<?php echo $banner_home['config']['velocidade'] ?>">
				            	<a target="<?php echo $banner['target']; ?>" href="<?php echo $banner['link'] ?>">
					                <div class="banner_inner" 
					                	 style="background: url('<?php echo $banner['imagem'] ?>');"
					                	 alt="<?php echo $banner['titulo']; ?>"></div>
				            	</a>
				            </div>
				        <?php } ?>
				    </div>
				    <button class="carousel-control-prev" type="button" data-bs-target="#BannerHome" data-bs-slide="prev">
				        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				        <span class="visually-hidden">Previous</span>
				    </button>
				    <button class="carousel-control-next" type="button" data-bs-target="#BannerHome" data-bs-slide="next">
				        <span class="carousel-control-next-icon" aria-hidden="true"></span>
				        <span class="visually-hidden">Next</span>
				    </button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

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
				<?php $uf = isset($_SESSION['location']->uf) ? $_SESSION['location']->uf : 'NA'; $consulta = "SELECT * FROM events WHERE status != 0 AND uf = '$uf' ORDER BY event_data ASC LIMIT 12";
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
						 style="background: url('attachments/eventos/photos/<?php echo $dado['photo']; ?>');"
						 <?php } else { ?>
						 style="background: url('attachments/eventos/capas/<?php echo $dado['title'] . '_' . $dado['banner']; ?>');"
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

<?php require "app/footer.php"; ?>
</body>
</html>