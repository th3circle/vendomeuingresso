<?php 

	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (isset($_SESSION['user_superadmin'])) { header("Location: ./eventos" . $_SESSION['tipo']['tipo']); }

	// ========================  variaveis

	require "../config/conn.php";

	$page_name = "Superadmin";
	require "../config/geral.php";

	require "../config/cdn.php";

	// ====================================

	if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['user']) AND isset($_POST['pass'])) {

		$user = $_POST['user'];
		$pass = hash('sha256', $_POST['pass']);

		$sql = "SELECT * FROM superadmin WHERE usuario='$user' AND senha='$pass'";
		$result = $conn->query($sql);

		if ($result->num_rows == 1) {

		    $user_data = $result->fetch_assoc();
		    $_SESSION['user_superadmin'] = $user_data;
		    header("Location: ./eventos");

		} else { $error_message = "Nome de usuário ou senha inválidos."; }

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/superadmin/login.css">
</head>
<body>
	<div class="align">
		<div class="container">
			<div class="row">
				<div class="col-11 col-lg-4 mx-auto">
					<div class="login_box">
						<form method="POST" action="">
							<h2>Superadmin</h2>
							<p>Entre com e-mail e senha para fazer login em nossa plataforma.</p>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-user align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui o seu usuário" type="text" name="user">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui a sua senha" type="password" name="pass">
									</div>
								</div>
							</div>
							<button style="margin-top: 15px; border-radius: 15px;" class="primario">ENTRAR</button>
							<?php if (isset($error_message)) { echo '<p class="error_message">'.$error_message.'</p>'; } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p class="copy">Desenvolvido com muito &#9749; por <a target="_blank" href="https://thecircle.com.br/">The Circle</a></p>
</body>
</html>