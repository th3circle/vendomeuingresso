<?php 


require "../config/conn.php";

if (isset($_GET['id'])) { $id = $_GET['id']; }

$query = "SELECT events.*, categories.nome AS nome_categoria
          FROM events
          INNER JOIN categories ON events.categoria = categories.id
          WHERE events.id = {$id}";

$mysqli_query 	= mysqli_query($conn, $query);
while ($data = mysqli_fetch_array($mysqli_query)) { $event = $data; }

$page_name = $event['title'];

require "../config/geral.php";
require "../config/cdn.php";

require "../config/functions/app.php";
require "../config/functions/auth.php";
require "../config/functions/user.php";

if (isset($_POST['pay'])) {

	if (isset($_SESSION['pay_data'])) { unset($_SESSION['pay_data']); }

	if (!isset($_SESSION['user_consumer'])) {

		$_SESSION['pay_data'] = $_POST;
		header('Location: '.$config["app_local"].'/login');


	} else {

		$_SESSION['pay_data'] = $_POST;
		header('Location: ./pay/');

	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/consumer/evento.css">
</head>
<body>
<?php if (isMobileDevice()) { require "../app/topbar_mobile.php"; } else { require "../app/topbar.php"; } ?>
	<div style="padding-top: 30px; padding-bottom: 20px;" class="container mt-50">
		<div class="row">
			<div class="col-12">
				<label onclick="window.history.back();" style="cursor: pointer;"><i class="fa-solid fa-angle-left fa-xs"></i> Voltar</label>
			</div>
			<div class="col-12">
				<div style="background: url('../attachments/eventos/capas/<?php if ($event['tipo'] == 2) {echo str_replace('REVENDA: ', '', $event['title']) . '_' . $event['banner'];} else {echo $event['title'] . '_' . $event['banner'];} ?>');" class="event_banner"></div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-8">
						<label alt="Forma com que o ingresso é vendido." class="tag categoria"><?php echo ($event['tipo'] == 1) ? "PRODUTOR" : (($event['tipo'] == 2) ? "REVENDA" : "Outro Tipo"); ?></label>
						<label alt="Categoria do evento." class="tag tipo_ingr"><?php echo strtoupper($event['nome_categoria']) ?></label>
						<br>
						<p class="b_title"><?php echo $event['title']; ?></p>
						<p>
							<?php echo $event['city'] . ', ' . $event['uf'] . ' - ' . $event['local'] ?> <br>
							<?php echo dateHour($event['event_data']); ?> <br>
							<?php echo fullMonth($event['event_data']); ?>

							<?php 

								// como chegar
								$local = $event['local'];
								$cidade = $event['city'];
								$uf = $event['uf'];

								// adicionar na agenda
						        $tituloEvento = $event['title'];
						        $dataInicio = date('c', strtotime($event['event_data']));
						        $dataFim = date('c', strtotime($event['event_data']));
						        $descricao = $event['description'];
						        $local = $event['city'] . ', ' . $event['uf'] . ' - ' . $event['local'];

							?>

						</p>

						<a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode($local . ', ' . $cidade . ', ' . $uf); ?>" target="_blank"><button class="act">
							<i class="fa-regular fa-compass"></i> 
							Como chegar
						</button></a>
						<a href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($tituloEvento); ?>&dates=<?php echo urlencode($dataInicio . '/' . $dataFim); ?>&details=<?php echo urlencode($descricao . '\nLocal: ' . $local); ?>" target="_blank"><button class="act">
							<i class="fa-regular fa-calendar"></i> 
							Adicionar na agenda
						</button></a>
						<a><button id="shareButton" class="act">
							<i class="fa-regular fa-share-from-square"></i> 
							Compartilhar
						</button></a>

						<p style="margin-top: 30px;" class="b">Informações gerais</p>
						<hr width="10%" style="border-color: #00000030;">

						<p>
							<?php echo $event['description'] ?>
						</p>

						<div style="margin-top: 55px;" style="text-align: justify;" class="rulesBox">
							<p class="purchaseRules"><?php 
								$purchaseRules = json_decode($config['purchase_rules'], true);
								if ($event['tipo'] == 1) {
									echo $purchaseRules['produtor'];
								} elseif ($event['tipo'] == 2) {
									echo $purchaseRules['revenda'];
								}
							?></p>
						</div>
					</div>
					<div style="position: relative !important;" class="col-4">
						<div class="ticketBox">
							<div class="">
								<div class="row ticket_dateBox">
									<div class="col-12 top">
										<div class="row">
											<div class="col-1">
												<i class="fa-solid fa-ticket align"></i> 
											</div>
											<div class="col-11">
												<div class="align">
													<label class="ticketLabel">Ingressos</label>
												</div>	
											</div>
										</div>
									</div>
									<?php if (isset($_GET['dia'])) { ?>
									<form method="POST" id="payForm" action="">
										
									    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
									    <input type="hidden" name="dia" value="<?php echo $_GET['dia']; ?>">

									    <?php
								    	$dia = $_GET['dia'];
										$arrayIngressos = json_decode($event['ingressos'], true);

										foreach ($arrayIngressos as $dia => $ingressos) { ?>

									    <div class="col-12">
									        <div class="row ticketDay">
									            <div class="col-3">
									                <input min="0" max="<?php echo $ingressos['estoque'] ?>" value="0" type="number" name="ticket[<?php echo $ingressos['tipo']; ?>][qntd]" class="ticket-quantity" data-price="<?php echo $ingressos['valor'] ?>">
									                <input type="hidden" value="<?php echo $ingressos['valor'] ?>" name="ticket[<?php echo $ingressos['tipo']; ?>][valor]">
									            </div>
									            <div class="col-9">
									                <div class="align">
									                    <p style="font-size: 0.8rem !important;" class="prieceDescription">
									                        <?php echo $ingressos['tipo']; ?> <br>
									                        <b style="font-size: 1.1rem !important;">R$ <?php echo number_format($ingressos['valor'], 2,',','.'); ?></b>
									                    </p>
									                </div>
									            </div>
									        </div>
									    </div>

										<?php } ?>

									    <input type="hidden" name="valor_total" id="valor_total" value="0.00">

									    <style>
									        .total_tickets {
									            margin-top: 20px;
									        }

									        .rightMoney label {
									            font-size: 0.8rem !important;
									        }

									        .rightMoney b {
									            font-size: 1.5rem !important;
									            font-weight: 600;
									        }
									    </style>
									    <div class="total_tickets" class="col-12">
									        <div class="row">
									            <div class="col-6">
									                <button name="pay" style="width: 100%; border-color: var(--secundaria); color: var(--secundaria);" class="act">
									                    <i class="fa-solid fa-cart-shopping"></i>
									                    Finalizar
									                </button>
									            </div>
									            <div style="text-align: right;" class="col-6 rightMoney">
									                <div class="align">
									                    <label>Total:</label><br>
									                    <b id="total_amount">R$ 0,00</b>
									                </div>
									            </div>
									        </div>
									    </div>
									</form>
									<script>
									    function calculateTotal() {
									        let total = 0.0;
									        const quantityInputs = document.querySelectorAll('.ticket-quantity');

									        quantityInputs.forEach(function(input) {
									            const price = parseFloat(input.getAttribute('data-price'));
									            const quantity = parseInt(input.value);
									            total += price * quantity;
									        });

									        const totalAmount = document.getElementById('total_amount');
									        totalAmount.textContent = 'R$ ' + total.toFixed(2);
									        document.getElementById('valor_total').value = total.toFixed(2);
									    }

									    const quantityInputs = document.querySelectorAll('.ticket-quantity');
									    quantityInputs.forEach(function(input) {
									        input.addEventListener('change', calculateTotal);
									    });

									    calculateTotal();
									</script>
									<?php } else {  ?>
									<div class="col-12">
										<?php $days = json_decode($event['days']);
										foreach ($days as $day => $data_day) {

											$day = strtotime($data_day);
											$n_day = date('d', $day);
											$month = strtoupper(monthToPT(date('M', $day)));
											$t_day = dayToName($day);

										?>
										<a style="text-decoration: none; color: #3d4650;" href="?pay_hash=<?php echo md5($data_day); ?>&id=<?php echo $_GET['id'] ?>&dia=<?php echo $data_day ?>">
											<div class="row ticketDay">
												<div class="col-2">
													<label class="day"><?php echo $n_day; ?></label>
												</div>
												<div style="padding-left: 5px;" class="col-2">
													<div class="align">
														<label class="month"><?php echo $month; ?></label><br>
														<label class="extenseDay"><?php echo $t_day; ?></label>
													</div>
												</div>
												<div class="col-7">
													<div class="align">
														<p class="prieceDescription">
															<?php 

															$ingressos = json_decode($event['ingressos'], true);

															$menorValor = null;
															$maiorValor = null;

															foreach ($ingressos as $data => $info) {
															    if ($data === $data_day) {
															        $valor = floatval($info['valor']);
															        if ($menorValor === null || $valor < $menorValor) {
															            $menorValor = $valor;
															        }
															        if ($maiorValor === null || $valor > $maiorValor) {
															            $maiorValor = $valor;
															        }
															    }
															}

															if ($menorValor == $maiorValor) { ?>
															Preço: <br>
															<b><?php echo 'R$ ' . number_format($maiorValor, 2,',','.') ?></b>
															<?php } else { ?>
															Preço entre <br>
															<b><?php echo 'R$ ' . number_format($menorValor, 2,',','.') . ' e ' . 'R$ ' . number_format($maiorValor, 2,',','.'); ?></b>
															<?php } ?>
														</p>
													</div>
												</div>
												<div class="col-1">
													<div class="align">
														<i class="fa-solid fa-chevron-right fa-2xl"></i>
													</div>
												</div>
											</div>
										</a>
										<?php } ?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require "../app/footer.php"; ?>
</body>
<script>
    document.getElementById('shareButton').addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: 'Título do Compartilhamento',
                text: 'Texto para compartilhar',
                url: window.location.href
            })
            .then(() => console.log('Compartilhado com sucesso'))
            .catch((error) => console.error('Erro ao compartilhar', error));
        } else {
            // Caso a API Web Share não seja suportada, abrir links diretos
            var sharedURL = encodeURIComponent(window.location.href);
            window.open(
                'https://wa.me/?text=' + sharedURL,
                'whatsapp-share',
                'width=600,height=400'
            );
            window.open(
                'https://www.facebook.com/sharer/sharer.php?u=' + sharedURL,
                'facebook-share',
                'width=600,height=400'
            );
            // Adicione mais links para outras plataformas de compartilhamento aqui
        }
    });
</script>
</html>