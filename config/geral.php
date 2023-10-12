<?php 

	// [Lancelot]: armazena as informações de config na variável.
	$query = "SELECT * FROM config";
	$mysqli_query = mysqli_query($conn, $query);
	while ($config_data = mysqli_fetch_array($mysqli_query)) { $config = $config_data; }

	if ($config['manutention'] == 'true') { require __DIR__ . "/404/manutencao.php"; }

	// [Lancelot]: inicia a sessão caso o ainda não tenha iniciado
	if (session_status() !== PHP_SESSION_ACTIVE){ session_start(); }

	// [Lancelot]: define o app_local do ambiente de teste
	if ($_SERVER['SERVER_ADDR'] == '::1') { $config['app_local'] = 'http://localhost/vendomeuingresso'; }

?>

<link rel="icon" type="image/x-icon" href="<?php echo $config['favicon']; ?>">
<title><?php echo $page_name . ' | ' . $config['app_name']; ?></title>