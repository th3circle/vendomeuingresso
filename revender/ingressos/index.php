<?php 

	$page_name = 'Novo Evento';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (!isset($_POST['step-one']) AND !isset($_POST['step-two'])) { header('Location: ../'); }

	$event = $_SESSION['event_data'];

	$event = array(
		"nome" 			=> $_SESSION['event_data']['nome'],
		"descricao" 	=> $_SESSION['event_data']['descricao'],
		"categoria" 	=> $_SESSION['event_data']['categoria'],
		"capa" 			=> $_SESSION['event_data']['capa'],
		"cep" 			=> $_SESSION['event_data']['cep'],
		"bairro" 		=> $_SESSION['event_data']['bairro'],
		"cidade" 		=> $_SESSION['event_data']['cidade'],
		"estado" 		=> $_SESSION['event_data']['estado'],
		"rua" 			=> $_SESSION['event_data']['rua'],
		"data" 			=> $_POST['data'],
	);

	$_SESSION['event_data'] = $event;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/novo-evento.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

</head>
<body style="padding-bottom: 50px !important;">
	<form id="form" method="POST" action="../finalizar/" enctype="multipart/form-data">
		<div class="alignContent">
			<div style="margin-bottom: 30px;" class="row">
				<div class="col-1">
					<img class="logo" src="<?php echo $config['logo_principal'] ?>">
				</div>
				<div class="col-5">
					<div class="align">
						<label class="title_top"><?php echo $event['nome']; ?></label>
					</div>
				</div>
				<div style="text-align: right;" class="col-6">
					<div class="align">
						<button type="button" onclick="window.location.href='../../'" class="act cancel">
							<i class="fa-solid fa-shop fa-sm"></i>
							Cancelar
						</button>
						<button class="act next">
							Avançar
							<i class="fa-solid fa-chevron-right fa-sm"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="progressbar"><div style="animation: expandWidth95 1s ease-in-out; width: 95%;" class="bar"></div></div>
			<div class="module">
				<div style="background: url('../../attachments/eventos/capas/<?php echo $event['nome'] . '_' . $event['capa']; ?>'); cursor: default !important;" id="capa" class="capa">
					<label style="opacity: 0 !important; cursor: default !important;" class="edit">
						<i class="fa-regular fa-pen-to-square"></i>
					</label>
				</div>

				<div class="contentInputs">
				    <div class="row">
				        <div style="margin-top: 25px;" id="dia" class="col-12">
				            <?php if (is_array($event['data'])) { ?>

				                <?php foreach ($event['data'] as $i => $data) { ?>

				                    <?php // Adicione um identificador único para cada row_ingresso baseado no índice $i ?>
				                    <div style="margin-bottom: 0px;" id="row_ingresso_<?php echo $i ?>" class="row">
				                    	<input type="hidden" name="ingresso[<?php echo $data ?>][id]">
				                        <div class="col-3">
				                            <label class="input">Tipo: <b class="req">*</b></label>
				                            <select class="address" name="ingresso[<?php echo $data ?>][tipo]">
				                            	<?php $tipo_ingressos = json_decode($config['tipo_ingressos'], true); ?>
				                            	<?php foreach ($tipo_ingressos as $tipo) { ?>
				                            	<option><?php echo $tipo ?></option>
				                           		<?php } ?>
				                            </select>
				                        </div>
				                        <div style="display: none;" class="col-1">
				                            <input type="hidden" value="1" name="ingresso[<?php echo $data ?>][estoque]" class="address">
				                        </div>
				                        <div class="col-2">
				                            <label class="input">Preço: <b class="req">*</b></label>
				                            <input type="text" placeholder="R$ 0,00" onkeyup="formatMoney(this)" name="ingresso[<?php echo $data ?>][valor]" class="address precoInput">
				                        </div>
				                        <div class="col-7">
				                            <label class="input">Obs:</label>
				                            <input type="text" placeholder="Alguma particularidade para este ingresso? Descreva aqui" name="ingresso[<?php echo $data ?>][obs]" class="address">
				                        </div>
				                    </div>

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

				            <?php } else { ?>

				                <h5><?php echo $event['data']; ?></h5>

				            <?php } ?>
				        </div>
				    </div>
				</div>

			</div>
		</div>
	</form>
</body>
<script>
function formatMoney(input) {
    let value = input.value;
    value = value.replace(/\D/g, "");
    value = parseFloat(value / 100).toFixed(2);
    value = value.replace(".", ",");
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    value = "R$ " + value;
    input.value = value;
}
document.getElementById('form').addEventListener('submit', function() {
    const precoInputs = document.querySelectorAll('.precoInput');
    precoInputs.forEach(input => {
        input.value = input.value.replace('R$ ', '').replace('.', '').replace(',', '.');
    });
});
</script>
</html>