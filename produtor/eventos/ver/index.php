<?php 

	$page_name = "Eventos";
	require "../../../config/cdn.php";
	require "../../../config/conn.php";
	require "../../../config/geral.php";

	require "../../app/producer_vars.php";
	require "../../../config/functions/app.php";
	require "../../../config/functions/money.php";

	$id = $producer['id'];
	$id_event = $_GET['id'];

	$query = "SELECT * FROM events WHERE id = '$id_event' AND business_id = '$id'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($evento_data = mysqli_fetch_array($mysqli_query)) { $evento = $evento_data; }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/vars.css">
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<?php require "../../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div style="margin-bottom: 20px;" class="row">
			<div class="col-6">
				<div class="align">
					<h1 class="title">Editar Evento</h1>
				</div>
			</div>
			<div style="text-align: right;" class="col-6">
				<button class="save">
					<i class="fa-solid fa-database fa-sm"></i>
					Salvar
				</button>
			</div>
		</div>
		<div style="margin-bottom: 30px;" class="row">

			<div class="col-12 col-sm-4 col-md-5 col-lg-4 col-xl-3 col-xxl-3">
				<div class="top_module">
					<div class="row">
						<div class="col-3">
							<div class="align">
								<i class="fa-solid fa-wallet iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label style="line-height: 1.2;" class="btmText">
									<?php 

									$query = "SELECT SUM(valor) AS total_registros FROM tickets_saled WHERE status = 1 AND event_id = '$id_event'";
									$result = $conn->query($query);
									if ($result) {
									    $row = $result->fetch_assoc();
									    $total = $row["total_registros"];
									    if ($total == null) { $total = 0; }
									}

									echo 'R$ ' . number_format(descLucro($total, $config['lucro']), 2,',','.')

									?>
								</label><br>
								<label class="topText">Receita liquida</label>
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
								<i class="fa-solid fa-clipboard-check iconModule"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="align">
								<label style="line-height: 1.2;" class="btmText">
									<?php 
										$query = "SELECT SUM(qntd) AS total_registros FROM tickets_saled WHERE status = 1 AND event_id = '$id_event'";
										$result = $conn->query($query);
										if ($result) {
										    $row = $result->fetch_assoc();
										    echo $row["total_registros"];
										}
									?>
								</label><br>
								<label class="topText">Ingressos vendidos</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div style="text-align: right;" class="col-6">
				<div class="align">
					<button onclick="window.location.href='./participantes?id=<?php echo $id_event ?>'" class="act_event">
						<i class="fa-solid fa-gear"></i> Participantes
					</button>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-3">

				<div class="module">
					<div class="menuEvent">

						<div id="btndados" class="linkEvent active">
							<div class="row">
								<div style="text-align: center;" class="col-2">
									<i class="fa-solid fa-database align"></i>
								</div>
								<div class="col-10">
									<div class="align">
										Dados do evento
									</div>
								</div>
							</div>
						</div>

						<div id="btningressos" class="linkEvent">
							<div class="row">
								<div style="text-align: center;" class="col-2">
									<i class="fa-regular fa-file-lines align"></i>
								</div>
								<div class="col-10">
									<div class="align">
										Ingressos
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-9">

				<div id="dados" class="row">
					<div class="col-12">
						<div id="capa" style="background: url('../../../attachments/eventos/capas/<?php echo $evento["title"] . "_" . $evento["banner"] ?>');" class="banner">
							<label class="edit">
								<i class="fa-regular fa-pen-to-square"></i>
							</label>
							<input required id="input_capa" type="file" name="evento_capa" style="display: none;">
						</div>
						<input type="text" class="input_title" value="<?php echo $evento['title'] ?>" name="event_title">
						<p style="margin-top: 10px; margin-bottom: 30px;">
							<?php echo $evento['city'] . ', ' . $evento['uf'] . ' - ' . $evento['local'] ?> <br>
							<?php echo dateHour($evento['event_data']); ?> <br>
							<?php echo fullMonth($evento['event_data']); ?>
						</p>
						<textarea id="evento_descricao">
							<?php echo $evento['description']; ?>
						</textarea>
					</div>
				</div>

				<div id="ingressos" style="display: none;" class="row">
					<div class="col-12">

						<?php $days = json_decode($evento['days'], true); foreach ($days as $i => $data) { ?>

						    <div class="date_title">
						        <div class="row">
						            <div class="col-6">
						                <div class="align">
						                    <h5 style="margin-left: 20px; font-weight: 400"><i class="fa-regular fa-calendar"></i> <?php echo date('d/m/Y', strtotime($data)); ?></h5>    
						                </div>
						            </div>
						            <div style="text-align: right;" class="col-6">
						                <button type="button" style="bottom: 0px;" class="act" onclick="adicionarIngresso(<?php echo $i ?>)">
						                    <i style="color: white !important;" class="fa-solid fa-plus"></i> Novo Ingresso
						                </button>
						            </div>
						        </div>
						    </div>

						    <?php $ingressos = json_decode($evento['ingressos'], true); foreach ($ingressos as $dia => $ingresso) { 
						        if ($dia == $data) { ?>
						        <div style="margin-bottom: 20px;" id="row_ingresso_<?php echo $i ?>" class="row">
						            <div class="col-sm">
						                <label class="input">Tipo: <b class="req">*</b></label>
						                <input disabled value="<?php echo $ingresso['tipo'] ?>" type="text" name="[<?php echo $data ?>][tipo]" class="address">
						            </div>
						            <div class="col-2">
						                <label class="input">Estoque: <b class="req">*</b></label>
						                <input style="text-align: center;" value="<?php echo $ingresso['estoque'] ?>" type="number" placeholder="0" min="0" name="[<?php echo $data ?>][estoque]" class="address">
						            </div>
						            <div class="col-2">
						                <label class="input">Preço: <b class="req">*</b></label>
						                <input type="text" placeholder="R$ 0,00" value="<?php echo $ingresso['valor'] ?>" onkeyup="formatMoney(this)" name="[<?php echo $data ?>][valor]" class="address precoInput">
						            </div>
						        </div>
						    <?php } } ?>

						<?php } ?>

		                <script>
		                    function adicionarIngresso(index) {
		                        // Clonar a div row_ingresso correspondente
		                        const rowIngressoOriginal = document.getElementById('row_ingresso_' + index);
		                        const rowIngressoClone = rowIngressoOriginal.cloneNode(true);
		                        
		                        // Limpar os campos clonados (opcional)
		                        const inputs = rowIngressoClone.querySelectorAll('input');
		                        inputs.forEach(input => {
		                            input.value = '';
		                        });

		                        // Adicionar o clone após o original
		                        rowIngressoOriginal.parentNode.insertBefore(rowIngressoClone, rowIngressoOriginal.nextSibling);
		                    }
		                </script>

					</div>
				</div>

			</div>
		</div>
	</div>
</body>
<script>
var btnDados = document.getElementById('btndados');
var divDados = document.getElementById('dados');

var btnIngressos = document.getElementById('btningressos');
var divIngressos = document.getElementById('ingressos');

btnDados.addEventListener('click', function() {
    divDados.style.display = 'block';
    divIngressos.style.display = 'none';
    btnIngressos.classList.remove('active');
    btnDados.classList.add('active');
});

btnIngressos.addEventListener('click', function() {
    divDados.style.display = 'none';
    divIngressos.style.display = 'block';
    btnIngressos.classList.add('active');
    btnDados.classList.remove('active');
});
</script>
<script>
const inputCapa = document.getElementById('input_capa');
const capaDiv = document.getElementById('capa');

capaDiv.addEventListener('click', function() {
    inputCapa.click();
});

inputCapa.addEventListener('change', function() {
    const file = inputCapa.files[0];

    if (file) {
        const objectURL = URL.createObjectURL(file);
        capaDiv.style.backgroundImage = `url('${objectURL}')`;
    } else {
        capaDiv.style.backgroundImage = 'none';
    }
});
</script>
<script>
  new FroalaEditor('textarea#evento_descricao')
</script>
</html>