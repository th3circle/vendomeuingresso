<?php 

	$page_name = 'Novo Evento';

	require "../config/conn.php";
	require "../config/geral.php";
	require "../config/cdn.php";

	require "../config/functions/app.php";
	require "../config/functions/auth.php";
	require "../config/functions/user.php";

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/produtor/novo-evento.css">
	<link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
</head>
<body>
	<form method="POST" action="./local/" enctype="multipart/form-data">
		<input type="hidden" name="step-one" value="true">
		<div class="alignContent">
			<div style="margin-bottom: 30px;" class="row">
				<div class="col-1">
					<img class="logo" src="<?php echo $config['logo_principal'] ?>">
				</div>
				<div class="col-5">
					<div class="align">
						<label class="title_top">Novo Evento</label>
					</div>
				</div>
				<div style="text-align: right;" class="col-6">
					<div class="align">
						<button type="button" onclick="window.location.href='../'" class="act cancel">
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
			<div class="progressbar"><div style="width: 15%;" class="bar"></div></div>
			<div class="module">
				<div id="capa" class="capa">
					<label class="edit">
						<i class="fa-regular fa-pen-to-square"></i>
					</label>
				</div>
				<input required id="input_capa" type="file" name="evento_capa" style="display: none;">
				<div class="row">
					<div class="col-12">
						<p class="capa_details">Para garantir uma ótima apresentação do banner, sugerimos o uso de uma imagem no formato JPG com as dimensões de 1675x450 pixels.</p>
					</div>
				</div>
				<div class="contentInputs">
					<div class="row">
						<div class="col-9">
							<label class="input">Nome do Evento: <b class="req">*</b></label>
							<input required placeholder="ex: Festival Rock in Rio" type="text" name="evento_nome">
						</div>
						<div class="col-3">
							<label class="input">Categoria do Evento: <b class="req">*</b></label>
							<select required style="padding: 16px; border-radius: 20px;" name="evento_categoria">
								<?php // [Lancelot]: faz a listagem das categeorias
								$consulta = "SELECT * FROM categories WHERE status != 0 ORDER BY nome ASC";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { ?>
								<option value="<?php echo $dado['id'] ?>"><?php echo $dado['nome'] ?></option>
								<?php } ?>
							</select>
						</div>
						<div style="margin-top: 15px;" class="col-12">
							<label class="input">Descrição do Evento: <b class="req">*</b></label>
							<textarea style="margin-top: 10px !important;" required name="evento_descricao" id="evento_descricao"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
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