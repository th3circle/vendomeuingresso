<?php 

	$page_name = "Eventos";
	require "../../config/cdn.php";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../app/producer_vars.php";

	$id = $producer['id'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">

	<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
</head>
<body>
	<?php require "../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-calendar-day iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status != 0 AND business_id = '$id'";
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Ativos</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-calendar-check iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros FROM events WHERE status = 0 AND business_id = '$id'";
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Finalizados</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-regular fa-calendar-minus iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label class="btmText">
									<?php 
										$query = "SELECT COUNT(*) AS total_registros FROM events WHERE business_id = '$id'";
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label>
								<label class="topText">Total</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="text-align: right; margin-bottom: 10px;" class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-3 col-xxl-3">
				<div class="acoes align">
					
					<!-- novo -->
					<button onclick="window.open('<?php echo $config['app_local'] ?>/novo-evento', '_blank');"  type="button" class="new" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa-solid fa-plus"></i>
					</button>
					
				</div>
			</div>
			<?php // [Lancelot]: faz a listagem dos eventos do usuário
			$consulta = "SELECT * FROM events WHERE status != 0 AND business_id = '$id'";
			$con = $conn->query($consulta) or die($conn->error);
			while($dado = $con->fetch_array()) { ?>
			<div style="margin-top: 30px;" class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-3">
				<div onclick="window.location.href='ver?id=<?php echo $dado['id'] ?>'" class="row event_box">
					<div class="col-12">
					<div class="event_pic" 
					    style="background: url('<?php
					        if (!empty($dado['photo'])) {
					            echo '../../attachments/eventos/photos/' . $dado['photo'];
					        } elseif (!empty($dado['banner'])) {
					            echo '../../attachments/eventos/capas/' . $dado['title'] . '_' . $dado['banner'];
					        } else {
					            echo 'https://i.ibb.co/s9RpmXw/no-pic.png';
					        }
				        ?>');">
					</div>
					</div>
					<div class="col-12">
						<div class="event_module">
							<div class="row">
								<div class="col-10">
									<label class="event_title"><?php echo $dado['title']; ?></label>
								</div>
								<div style="text-align: right;" class="col-2">
									<div class="align">
										<i onclick="window.location.href='./ver/?id=<?php echo $dado['id']; ?>'" class="fa-regular fa-eye fa-sm"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div style="margin-top: 80px;" class="col-12">
				<div style="margin-bottom: 15px;" class="row">
					<div class="col-6">
						<div class="align">
							<h1 class="titleCalendar">Calendário de Eventos</h1>
						</div>
					</div>
					<div style="text-align: right;" class="col-6">
						<div class="align">
							<button id="prevMonth"><</button>
							<button id="nextMonth">></button>
						</div>
					</div>
				</div>
				<div class="module" style="height: 400px; padding: 5px; overflow: hidden;" id='calendar'></div>
			</div>
		</div>
	</div>
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
<script type="text/javascript">
var calendar = new tui.Calendar(document.getElementById('calendar'), {
   defaultView: 'month',
    month: {
      visibleWeeksCount: 4,
    },
});

calendar.createEvents([
	<?php // [Lancelot]: faz a listagem dos eventos do usuário para o calendario
	$consulta = "SELECT * FROM events WHERE business_id = '$id'";
	$con = $conn->query($consulta) or die($conn->error);
	while($dado = $con->fetch_array()) { ?>
		{
			<?php $datesArray = json_decode($dado['days']);
			if (is_array($datesArray) && count($datesArray) > 0) {
				$firstDate = $datesArray[0];
				$lastDate = end($datesArray);
			} ?>

			title: '<?php echo $dado['title'] ?>',
			start: '<?php echo $firstDate ?>',
			end: '<?php echo $lastDate ?>',
			backgroundColor: '<?php echo $config['cor_secundaria'] ?>',
			color: 'white',
		},
	<?php } ?>
]);

// Função para avançar para o próximo mês
document.getElementById('nextMonth').addEventListener('click', function() {
  calendar.next();
});

// Função para retroceder para o mês anterior
document.getElementById('prevMonth').addEventListener('click', function() {
  calendar.prev();
});
</script>
</body>
</html>