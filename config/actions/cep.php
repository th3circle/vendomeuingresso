<?php 

	session_start();

	if (isset($_SESSION['location'])) {
	    unset($_SESSION['location']);
	}

	$cep = $_POST['cep'];
	$cepDetails = json_decode(file_get_contents("https://viacep.com.br/ws/{$cep}/json/"));

	if ($cepDetails) {
	    $_SESSION['location'] = $cepDetails;
	    echo "<script>window.history.back();</script>";
	} else {
		unset($_SESSION['location']);
	    echo "<script>window.history.back();</script>";
	}

?>