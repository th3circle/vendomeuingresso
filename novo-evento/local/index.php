<?php 

	$page_name = 'Novo Evento';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (!isset($_POST['step-one']) OR $_POST['step-one'] != 'true') { header('Location: ../'); }

	$stepOne_nome 			= $_POST['evento_nome'];
	$stepOne_descricao 		= $_POST['evento_descricao'];
	$stepOne_categoria 		= $_POST['evento_categoria'];
	$stepOne_capa 			= $_FILES['evento_capa']['name'];

	$stepOne_capa_tmp 			= $_FILES['evento_capa']['tmp_name'];
	$destination = '../../attachments/eventos/capas/' . $stepOne_nome . '_' . $stepOne_capa;
	move_uploaded_file($stepOne_capa_tmp, $destination);

	$event = array(
		"nome" => $stepOne_nome,
		"descricao" => $stepOne_descricao,
		"categoria" => $stepOne_categoria,
		"capa" => $stepOne_capa,
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
<body>
	<form method="POST" action="../dias/" enctype="multipart/form-data">

		<input type="hidden" name="step-one" value="true">
		<input type="hidden" name="step-two" value="true">

		<div class="alignContent">
			<div style="margin-bottom: 30px;" class="row">
				<div class="col-1">
					<img class="logo" src="<?php echo $config['logo_principal'] ?>">
				</div>
				<div class="col-5">
					<div class="align">
						<label class="title_top"><?php echo $stepOne_nome; ?></label>
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
			<div class="progressbar"><div style="animation: expandWidth 1s ease-in-out; width: 35%;" class="bar"></div></div>
			<div class="module">
				<div style="background: url('<?php echo $destination; ?>'); cursor: default !important;" id="capa" class="capa">
					<label style="opacity: 0 !important; cursor: default !important;" class="edit">
						<i class="fa-regular fa-pen-to-square"></i>
					</label>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="capa_details">Para garantir uma ótima apresentação do banner, sugerimos o uso de uma imagem no formato JPG com as dimensões de 1675x450 pixels.</p>
					</div>
				</div>
				<div class="contentInputs">
					<div class="row">
						<div class="col-2">
							<label class="input">CEP: <b class="req">*</b></label>
							<input id="cep" onblur="buscaCEP()" required type="text" class="address" name="endereco_cep">
						</div>
						<div class="col-2">
							<label class="input">Cidade: <b class="req">*</b></label>
							<input id="endereco_cidade" placeholder="ex: São Paulo" required type="text" class="address" name="endereco_cidade">
						</div>
						<div class="col-2">
							<label class="input">Estado: <b class="req">*</b></label>
							<input id="endereco_estado" placeholder="ex: São Paulo" required type="text" class="address" name="endereco_estado">
						</div>
						<div class="col-2">
							<label class="input">Bairro: <b class="req">*</b></label>
							<input id="endereco_bairro" placeholder="ex: Pinheiros" required type="text" class="address" name="endereco_bairro">
						</div>
						<div class="col-sm">
							<label class="input">Local: <b class="req">*</b></label>
							<input id="endereco_local" placeholder="ex: Rua 22, Expo Central, 123" required class="address" type="text" name="endereco_local">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
<script type="text/javascript">
function buscaCEP() {
    const cep = document.getElementById('cep').value;
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById('endereco_cidade').value = data.localidade;
                document.getElementById('endereco_estado').value = data.uf;
                document.getElementById('endereco_bairro').value = data.bairro;
                document.getElementById('endereco_local').value = data.logradouro;
            } else {
                document.getElementById('endereco_cidade').disabled = false;
                document.getElementById('endereco_estado').disabled = false;
                document.getElementById('endereco_bairro').disabled = false;
                document.getElementById('endereco_local').disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro ao buscar CEP:', error);
            document.getElementById('endereco_cidade').disabled = false;
            document.getElementById('endereco_estado').disabled = false;
            document.getElementById('endereco_bairro').disabled = false;
            document.getElementById('endereco_local').disabled = false;
        });
}
$(document).ready(function() {
  $('#cep').inputmask('99999999');
});
</script>
</html>