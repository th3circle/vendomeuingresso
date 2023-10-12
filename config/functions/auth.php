<?php 

	// [Lancelot]: função que verifica se o usuário está logado
	function isLoged($type) { if (session_status() == PHP_SESSION_ACTIVE AND isset($_SESSION[$type])){ return true; } else { return false; } }

	// [Lancelot]: define a variável de consumo do db.
	if (isLoged('user_consumer') == true) {

		$id = $_SESSION['user_consumer']['id'];
		$query = "SELECT * FROM users WHERE id = '$id'";
		$mysqli_query = mysqli_query($conn, $query);
		while ($consumer_data = mysqli_fetch_array($mysqli_query)) { $consumer = $consumer_data; }

	}

?>