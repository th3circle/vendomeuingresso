<?php 

	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (isset($_SESSION['user_producer'])) { header("Location: ./eventos"); }

	// ========================  variaveis

	require "../config/conn.php";

	$page_name = "Produtor";
	require "../config/geral.php";

	require "../config/cdn.php";

	// ====================================

	if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['email']) AND isset($_POST['pass'])) {

		$email = $_POST['email'];
		$pass = hash('sha256', $_POST['pass']);

		$sql = "SELECT * FROM producer WHERE email='$email' AND senha='$pass' AND status = 1";
		$result = $conn->query($sql);

		if ($result->num_rows == 1) {

		    $user_data = $result->fetch_assoc();
		    $_SESSION['user_producer'] = $user_data;
		    header("Location: ./eventos");

		} else { $error_message = "E-mail ou senhas incorretos ou inexistentes."; }

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/produtor/login.css">
</head>
<body>
	<div class="align">
		<div class="container">
			<div class="row">
				<div class="col-11 col-lg-4 mx-auto">
					<div class="top_loginbox">
						<div class="row">
							<div onclick="window.location.href='../login';" style="padding-right: 0px;" class="col-6">
								<div class="normal">
									<label>Usuário</label>
								</div>
							</div>
							<div onclick="window.location.href='./';" style="padding-left: 0px;" class="col-6">
								<div class="active">
									<label>Produtor</label>
								</div>
							</div>
						</div>
					</div>
					<div class="login_box">
						<form method="POST" action="">
							<h2>Produtor</h2>
							<p>Entre com e-mail e senha para fazer login em nossa plataforma.</p>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-envelope align"></i>
									</div>
									<div class="col-10 right_input">
										<input value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>" required placeholder="Insira aqui o seu e-mail" type="email" name="email">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui a sua senha" type="password" minlength="8" name="pass">
									</div>
								</div>
							</div>
							<button style="margin-top: 15px; border-radius: 15px;" class="primario">ENTRAR</button>
							<p onclick="window.location.href='./cadastrar';" class="cadastrar">CADASTRAR</p>
							<?php if (isset($error_message)) { echo '<p class="error_message">'.$error_message.'</p>'; } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p class="copy">Desenvolvido com muito &#9749; por <a target="_blank" href="https://thecircle.com.br/">The Circle</a></p>
	<img class="memphis_bg" src="assets/img/<?php echo $config['logo_white']; ?>">
</body>
</html>