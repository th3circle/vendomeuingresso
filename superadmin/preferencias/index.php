<?php 

	$page_name = "Preferências";
	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";
	require "../app/admin_vars.php";

	$id = $superadmin['id'];

	if (isset($_POST['filter'])) {

		$dataInicial	= $_POST['filter_dateInit'];
		$dataFinal		= $_POST['filter_dateEnd'];
		$status 		= $_POST['filter_status'];

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/evento.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/superadmin/preferencias.css">

</head>
<body>
	<?php require "../app/leftbar_admin.php"; ?>
	<div class="container">
		<div style="overflow: hidden;" class="module">
			<div class="header_title">
				<div class="row">
					<div style="padding-right: 0px;" class="col-sm">
						<div id="btn_sistema" class="top_preference">
							Sistema
						</div>
					</div>
					<div style="padding-left: 0px; padding-right: 0px;" class="col-sm">
						<div id="btn_design" class="top_preference">
							Design
						</div>
					</div>
					<div style="padding-left: 0px; padding-right: 0px;" class="col-sm">
						<div id="btn_email" class="top_preference">
							E-mail
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="hr"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="content">
						
						<div style="display: none;" id="sistema">
							<div class="row">
							    <div class="col-12">
							        <h1 class="h1_title">Manutenção:</h1>
							    </div>
							</div>
							<div class="row">
							    <div class="col-sm">
									<table class="table">
										<tbody>
											<tr>
												<td class="align-middle" style="width: 4% !important; padding-left: 0px !important; text-align: left;">
													<div style="padding: 0px !important;" class="form-switch">		
													    <input style="margin: 0px !important;" class="form-check-input" type="checkbox" name="remember_me">
													</div>
												</td>
												<td style="text-align: left;" class="align-middle">
													<p class="desc"><i class="fa-solid fa-circle-exclamation"></i> Quando ativado, toda a plataforma ficará inacessível para os usuários finais.</p>
												</td>
											</tr>
										</tbody>
									</table>
							    </div>
							</div>
							<div style="margin-top: 35px;" class="row">
							    <div class="col-12">
							        <h1 class="h1_title">Dados do App:</h1>
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-4">
							        <label class="input">Nome do App <b class="req">*</b></label>
							        <input value="<?php echo $config['app_name'] ?>" type="text" name="app_name">
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							        <label class="input">Local do App <b class="req">*</b></label>
							        <input value="<?php echo $config['app_local'] ?>" type="text" name="app_local">
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-3">
							        <label class="input">Limite de Categorias na home <b class="req">*</b></label>
							        <input value="<?php echo $config['limite_categorias'] ?>" type="number" name="app_limite_categories">
							    </div>
							</div>
						</div>

						<div style="display: none;" id="design">
							<div class="row">
								<div class="col-2">
									<div style="margin-top: ;" class="row">
									    <div class="col-12">
									        <h1 class="h1_title">Cores:</h1>
									    </div>
									</div>
									<div style="margin-top: 10px;" class="row">
									    <div class="col-12">
									        <label style="background: transparent; margin-bottom: 5px;" class="input">Cor Principal <b class="req">*</b></label><br>
									        <input style="background: <?php echo $config['cor_primaria'] ?>;" type="cor" name="cor_primaria" value="<?php echo strtoupper($config['cor_primaria']); ?>">
									    </div>
									</div>
									<div style="margin-top: 10px;" class="row">
									    <div class="col-12">
									        <label style="background: transparent; margin-bottom: 5px;" class="input">Cor Secundária <b class="req">*</b></label><br>
									        <input style="background: <?php echo $config['cor_secundaria'] ?>;" type="cor" name="cor_secundaria" value="<?php echo strtoupper($config['cor_secundaria']); ?>">
									    </div>
									</div>
									<div style="margin-top: 10px;" class="row">
									    <div class="col-12">
									        <label style="background: transparent; margin-bottom: 5px;" class="input">Cor Background <b class="req">*</b></label><br>
									        <input style="background: <?php echo $config['cor_background'] ?>; color: #000000ae;" type="cor" name="cor_background" value="<?php echo strtoupper($config['cor_background']); ?>">
									    </div>
									</div>
									<div style="margin-top: 10px;" class="row">
									    <div class="col-12">
									        <label style="background: transparent; margin-bottom: 5px;" class="input">Cor Categorias <b class="req">*</b></label><br>
									        <input style="background: <?php echo $config['cor_categorias'] ?>;" type="cor" name="cor_categorias" value="<?php echo strtoupper($config['cor_categorias']); ?>">
									    </div>
									</div>
								</div>
							</div>
							<div style="margin-top: 35px;" class="row">
							    <div class="col-12">
							        <h1 class="h1_title">Logos:</h1>
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							    	<div class="align">
								        <label class="input">Logo Principal <b class="req">*</b></label>
								        <input value="<?php echo $config['logo_principal'] ?>" type="text" name="app_limite_categories">
							    	</div>
							    </div>
							    <div class="col-1">
							    	<img style="padding: 15px; width: 100%;" src="<?php echo $config['logo_principal'] ?>">
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							    	<div class="align">
								        <label class="input">Logo Produtor (branca) <b class="req">*</b></label>
								        <input value="<?php echo $config['logo_produtor'] ?>" type="text" name="app_limite_categories">
							    	</div>
							    </div>
							    <div style="background: #00000050; border-radius: 15px;" class="col-1">
							    	<div style="padding: 10px;" class="align">
							    		<img style="width: 100%;" src="<?php echo $config['logo_produtor'] ?>">
							    	</div>
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							    	<div class="align">
								        <label class="input">Logo Admin (branca) <b class="req">*</b></label>
								        <input value="<?php echo $config['logo_admin'] ?>" type="text" name="app_limite_categories">
							    	</div>
							    </div>
							    <div style="background: #00000050; border-radius: 15px;" class="col-1">
							    	<div class="align">
							    		<img style="width: 100%;" src="<?php echo $config['logo_admin'] ?>">
							    	</div>
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							    	<div class="align">
								        <label class="input">Logo Branca (branca) <b class="req">*</b></label>
								        <input value="<?php echo $config['logo_white'] ?>" type="text" name="app_limite_categories">
							    	</div>
							    </div>
							    <div class="col-1">
							    	<div class="align">
							    		<img style="filter: invert(100%); padding: 15px; width: 100%;" src="<?php echo $config['logo_white'] ?>">
							    	</div>
							    </div>
							</div>
							<div style="margin-top: 10px;" class="row">
							    <div class="col-5">
							    	<div class="align">
								        <label class="input">Favicon <b class="req">*</b></label>
								        <input value="<?php echo $config['favicon'] ?>" type="text" name="app_limite_categories">
							    	</div>
							    </div>
							    <div class="col-1">
							    	<div class="align">
							    		<img style="width: 80%;" src="<?php echo $config['favicon'] ?>">
							    	</div>
							    </div>
							</div>
						</div>

						<div id="email">
							<div style="margin-bottom: 30px;" class="row">
								<div class="col-12">
									<h1 class="h1_title">E-mail: SMTP</h1>
									<p class="desc">Não altere essas informações a não ser que saiba o que está fazendo.</p>
								</div>
							</div>
							<div style="margin-bottom: 15px;" class="row">
								<div class="col-3">
									<label class="input">Host SMTP <b class="req">*</b></label>
									<input type="text" name="smtp_host" value="<?php echo $config['smtp_host'] ?>">
								</div>
							</div>
							<div style="margin-bottom: 15px;" class="row">
								<div class="col-3">
									<label class="input">User SMTP <b class="req">*</b></label>
									<input type="email" name="smtp_user" value="<?php echo $config['smtp_user'] ?>">
								</div>
							</div>
							<div style="margin-bottom: 15px;" class="row">
								<div class="col-3">
									<label class="input">Pass SMTP <b class="req">*</b></label>
									<input type="password" name="smtp_pass" value="<?php echo $config['smtp_pass'] ?>">
								</div>
							</div>
							<div style="margin-bottom: 15px;" class="row">
								<div class="col-3">
									<label class="input">Port SMTP <b class="req">*</b></label>
									<input type="text" name="smtp_port" value="<?php echo $config['smtp_port'] ?>">
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div style="text-align: right;">
			<button class="act"><i style="margin-right: 5px;" class="fa-solid fa-floppy-disk fa-sm"></i> Salvar</button>
		</div>
	</div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Obtém referências para os botões e divs
    var btnSistema = document.getElementById("btn_sistema");
    var btnDesign = document.getElementById("btn_design");
    var btnEmail = document.getElementById("btn_email");

    var divSistema = document.getElementById("sistema");
    var divDesign = document.getElementById("design");
    var divEmail = document.getElementById("email");

    btnSistema.addEventListener("click", function() {
        setActive(btnSistema);
        showContent(divSistema);
    });

    btnDesign.addEventListener("click", function() {
        setActive(btnDesign);
        showContent(divDesign);
    });

    btnEmail.addEventListener("click", function() {
        setActive(btnEmail);
        showContent(divEmail);
    });

    function setActive(button) {
        btnSistema.classList.remove("active");
        btnDesign.classList.remove("active");
        btnEmail.classList.remove("active");

        button.classList.add("active");
    }

    function showContent(contentDiv) {
        divSistema.style.display = "none";
        divDesign.style.display = "none";
        divEmail.style.display = "none";
        contentDiv.style.display = "block";
    }

    setActive(btnSistema);
    showContent(divSistema);
});
</script>
</html>