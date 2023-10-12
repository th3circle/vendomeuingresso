<?php 

	$page_name = "Ajustes";
	require "../../../config/conn.php";
	require "../../../config/geral.php";
	require "../../../config/cdn.php";
	require "../../app/producer_vars.php";
	require '../../../vendor/autoload.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$id = $producer['id'];

	if (isset($_POST['nome']) && isset($_POST['email'])) {

	    $nome_completo = explode(" ", $_POST['nome']);

	    $nome = $nome_completo[0];
	    $sobrenome = implode(" ", array_slice($nome_completo, 1));
	    $funcao = $_POST['tipo'];
	    $email = $_POST['email'];

	    $checkQuery = "SELECT * FROM producer WHERE email = '$email'";
	    $checkResult = $conn->query($checkQuery);

	    if ($checkResult->num_rows > 0) {
	        echo '<script>alert("Erro: #3192NDKEX | Este email já está cadastrado.");window.location.href="./"</script>';
	    } else {

	        $query = "INSERT INTO producer (vinculo_id, vinculo_tipo, name, surname, email, status) VALUES ('$id', '$funcao', '$nome', '$sobrenome', '$email', 4)";

	        if ($conn->query($query) === TRUE) {

	            $mail = new PHPMailer(true);

	            try {
	            	
	                $mail->isSMTP();
	                $mail->Host       = $config['smtp_host'];
	                $mail->SMTPAuth   = true;
	                $mail->Username   = $config['smtp_user'];
	                $mail->Password   = $config['smtp_pass'];
	                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	                $mail->Port       = $config['smtp_port'];

	                $mail->setFrom($config['smtp_user'], $config['app_name']);
	                $mail->addAddress($email, $_POST['nome']);

	                $mail->isHTML(true);
	                $mail->Subject = utf8_decode('Não Responda: ' . $nome . ', seja bem vindo(a) ao ' . $config['app_name'] . '!');
	    			$mail->Body = 'Para acessar a plataforma, complete o seu cadastro acessando este <a href="'.$config["app_local"].'/produtor/pre-cadastro/?hs='.md5($email).'">link</a>. <br><br>Ou copie e cole em seu navegador: '.$config["app_local"].'/produtor/pre-cadastro/?hs='.md5($email);

	                $mail->send();
	                echo '<script>window.location.href="./"</script>';

	            } catch (Exception $e) {
	                echo '<script>alert("Erro no envio de email. Contacte o suporte.");window.location.href="./"</script>';
	            }

	        } else {
	            echo '<script>alert("Erro: #3192NDKQR | Erro ao inserir! Contacte o suporte.");window.location.href="./"</script>';
	        }
	    }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/vars.css">
	<link rel="stylesheet" type="text/css" href="../../../assets/css/produtor/ajustes.css">
</head>
<body>
	<?php require "../../app/leftbar_eventos.php"; ?>
	<div class="container">
		<div class="row">
			<div style="margin-bottom: 20px;" class="col-12">
				<form method="POST" action="" id="newUser">
					<div class="row">
						<div class="col-sm">
							<h5 class="title_module">Adicionar Usuário</h5>
						</div>
						<div class="col-3">
							<label class="input">Nome Completo: <b class="req">*</b></label>
							<input type="text" name="nome">
						</div>
						<div class="col-2">
							<label class="input">Tipo: <b class="req">*</b></label>
							<select name="tipo">
								<option>Administrador</option>
								<option>Portaria</option>
								<option>Equipe</option>
							</select>
						</div>
						<div class="col-3">
							<label class="input">E-mail: <b class="req">*</b></label>
							<input type="email" name="email">
						</div>
						<div class="col-1">
							<button form="newUser" class="act"><i class="fa-solid fa-plus"></i> Add</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-3">
				<div class="module tip">
					<label class="titleTip">
						<i class="fa-solid fa-circle-info"></i>
						Dica
					</label>
					<p class="descTip">
						Para adicionar um novo usuário ao seu Workspace, basta inserir o nome completo e o e-mail da pessoa desejada ao lado. Posteriormente, a pessoa receberá um e-mail contendo as informações de acesso, incluindo seu usuário e um link para acessar a plataforma.
						<br><br>						
						Além disso, você tem a opção de escolher o tipo de usuário entre três categorias diferentes:
					</p>
					<div class="descTip">
						<table class="table">
							<tr class="headerTip">
								<td style="width: 10px; padding: 8px 0px;" class="align-middle">
									<i class="fa-solid fa-user-gear fa-xs iconTip"></i>
								</td>
								<td style="text-align: left;" class="align-middle">
									<b>Usuário Admin:</b><br>
								</td>
							</tr>
						</table>
						O usuário admin tem acesso a todas as funções do módulo do produtos, sem restrições.
						<br><br>
						<table class="table">
							<tr class="headerTip">
								<td style="width: 10px; padding: 8px 0px;" class="align-middle">
									<i class="fa-solid fa-user-group fa-xs iconTip"></i>
								</td>
								<td style="text-align: left;" class="align-middle">
									<b>Usuário Equipe:</b><br>
								</td>
							</tr>
						</table>
						O usuário equipe tem acesso a visualização e edição do evento, assim como criação de novos ingressos e manutenção do estoques.
						<br><br>
						<table class="table">
							<tr class="headerTip">
								<td style="width: 10px; padding: 8px 0px;" class="align-middle">
									<i class="fa-solid fa-user-shield fa-xs iconTip"></i>
								</td>
								<td style="text-align: left;" class="align-middle">
									<b>Usuário Portaria:</b><br>
								</td>
							</tr>
						</table>
						O usuário portaria só tem acesso ao módulo de conferência do QR-Code do ingresso.
					</div>
				</div>
			</div>
			<div class="col-9">
				<div class="module">
					<div class="row">
						<div class="col-12">
							<table class="table">
								<thead>
									<tr>
										<th class="left">Nome</th>
										<th class="center">Função</th>
										<th class="left">E-mail</th>
										<th class="center">Status</th>
										<th class="right"></th>
									</tr>
								</thead>
								<tbody>
									<?php // [Lancelot]: faz a listagem das categeorias
									$consulta = "SELECT * FROM producer WHERE vinculo_id = '$id'";
									$con = $conn->query($consulta) or die($conn->error);
									while($dado = $con->fetch_array()) { ?>
									<tr>
										<td width="20%" class="left">
											<?php echo $dado['name'] . ' ' . $dado['surname']; ?>
										</td>
										<td width="15%" class="center">
											<?php echo $dado['vinculo_tipo'] ?>
										</td>
										<td width="30%" class="left">
											<?php echo $dado['email'] ?>
										</td>
										<td width="15%" class="center">
											<?php if ($dado['status'] == 1) { 
												echo '<label class="status status_ativo">ATIVO</label>'; 
											} elseif ($dado['status'] == 4) {
												echo '<label class="status status_inativo">E-MAIL ENVIADO</label>'; 
											} else { 
												echo '<label class="status status_inativo">INATIVO</label>'; 
											} ?>
										</td>
										<td width="10%" class="right">
											<div class="actions">
												
												<?php if ($dado['verify_email'] == 0) { $nome = $dado['name'] . ' ' . $dado['surname']; $email = $dado['email'] ?>
												<i onclick="window.location.href='acoes/resend.php?nome=<?php echo $nome ?>&email=<?php echo $email ?>'" class="fa-solid fa-envelope-open-text fa-sm"></i> 
												<?php } ?>
												<i onclick="window.location.href='acoes/status.php?id=<?php echo $dado['id'] ?>&status=<?php echo $dado['status'] ?>'" class="fa-solid fa-power-off fa-sm"></i>
												<i onclick="confirmAlert('Atenção! Esta ação é irreversível!', './acoes/delete.php?id=<?php echo $dado["id"] ?>')" class="fa-regular fa-trash-can fa-sm"></i>

											</div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function confirmAlert(msg, link) {
    var resposta = confirm(msg);
    if (resposta === true) {
        window.location.href = link;
    }
}
</script>
</html>