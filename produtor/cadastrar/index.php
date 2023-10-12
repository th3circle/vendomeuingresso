<?php 

	$page_name = 'Cadastrar';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	if (isset($_POST['register'])) {

	    $user_pass      = $_POST['user_pass'];
	    $user_repass    = $_POST['user_repass'];

	    if ($user_pass == $user_repass) {

	        $user_nome      = $_POST['user_nome'];
	        $user_sobrenome = $_POST['user_sobrenome'];
	        $user_email     = $_POST['user_email'];
	        $user_cpfcnpj   = $_POST['user_cpfcnpj'];
	        $user_passHash  = hash('sha256', $_POST['user_pass']);

	        $check_query = "SELECT id FROM producer WHERE email = '$user_email' OR cpf_cnpj = '$user_cpfcnpj'";
	        $check_result = $conn->query($check_query);

	        if ($check_result && $check_result->num_rows > 0) {
	            echo '<script>alert("E-mail já cadastrado!");</script>';
	        } else {

	            $query = "INSERT INTO producer (name, surname, email, cpf_cnpj, senha)
	                      VALUES ('$user_nome', '$user_sobrenome', '$user_email', '$user_cpfcnpj', '$user_passHash')";

	            if ($conn->query($query) === TRUE) {

	                $id_producer = $conn->insert_id;
	                
	                $_SESSION['user_producer'] = array(
	                    "id" => $id_producer,
	                    "nome" => $user_nome,
	                    "sobrenome" => $user_sobrenome,
	                    "email" => $user_email,
	                    "cpf_cnpj" => $user_cpfcnpj,
	                    "passHash" => $user_passHash,
	                );

	                header('Location: ../eventos');

	            } else {
	                echo '<script>alert("#8193NLD0 | Erro ao executar a ação! Contacte o suporte.");</script>';
	            }
	        }
	    } else {
	        $error_message = "As senhas não conferem.";
	    }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/geralVars.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/produtor/login.css">
</head>
<body>
	<div class="align">
		<div class="container">
			<div class="row">
				<div class="col-11 col-lg-4 mx-auto">

					<div style="border-top: 15px solid var(--secundaria);" id="registerBox" class="login_box">
						<form method="POST" id="registerForm" action="">
							<h2>Cadastrar</h2>
							<p style="width: 100%;">Crie uma conta para publicar o seu evento.</p>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-user align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Nome" type="text" value="<?php if (isset($_POST['user_nome'])) { echo $_POST['user_nome']; } ?>" name="user_nome">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-user align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Sobrenome" type="text" value="<?php if (isset($_POST['user_sobrenome'])) { echo $_POST['user_sobrenome']; } ?>" name="user_sobrenome">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-passport align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="CPF ou CNPJ" id="cpf_cnpj" oninput="this.value = formatCPF_CNPJ(this.value)" maxlength="18" type="text" value="<?php if (isset($_POST['user_cpfcnpj'])) { echo $_POST['user_cpfcnpj']; } ?>" name="user_cpfcnpj">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-envelope align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="E-mail" type="email" value="<?php if (isset($_POST['user_email'])) { echo $_POST['user_email']; } ?>" name="user_email">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Insira aqui a sua senha" type="password" name="user_pass">
									</div>
								</div>
							</div>
							<div class="input">
								<div class="row">
									<div class="col-2 left_input">
										<i class="fa-solid fa-lock align"></i>
									</div>
									<div class="col-10 right_input">
										<input required placeholder="Repita a sua senha" type="password" name="user_repass">
									</div>
								</div>
							</div>
							<button form="registerForm" style="margin-top: 15px; border-radius: 15px;" value="<?php if (isset($_POST['register'])) { echo $_POST['register']; } ?>" name="register" class="primario">CADASTRAR</button>
							<p onclick="window.location.href='../'" id="fazer-login" class="cadastrar">FAZER LOGIN</p>
							<?php if (isset($error_message)) { echo '<p class="error_message">'.$error_message.'</p>'; } ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<p class="copy">Desenvolvido com muito &#9749; por <a target="_blank" href="https://thecircle.com.br/">The Circle</a></p>
</body>
<script>
function formatCPF_CNPJ(input) {
    const cleanInput = input.replace(/\D/g, '');

    if (cleanInput.length === 11) { // CPF
        return cleanInput.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (cleanInput.length === 14) { // CNPJ
        return cleanInput.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }

    return input;
}
</script>
</html>