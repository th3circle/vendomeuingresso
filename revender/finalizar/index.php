<?php 

	$page_name = 'Novo Evento';

	require "../../config/conn.php";
	require "../../config/geral.php";
	require "../../config/cdn.php";

	require "../../config/functions/app.php";
	require "../../config/functions/auth.php";
	require "../../config/functions/user.php";

	$event = $_SESSION['event_data'];

	if (isset($_POST['ingresso'])) {
		$event = array(
			"nome" 			=> $_SESSION['event_data']['nome'],
			"descricao" 	=> $_SESSION['event_data']['descricao'],
			"categoria" 	=> $_SESSION['event_data']['categoria'],
			"capa" 			=> $_SESSION['event_data']['capa'],
			"cep" 			=> $_SESSION['event_data']['cep'],
			"bairro" 		=> $_SESSION['event_data']['bairro'],
			"cidade" 		=> $_SESSION['event_data']['cidade'],
			"estado" 		=> $_SESSION['event_data']['estado'],
			"rua" 			=> $_SESSION['event_data']['rua'],
			"data" 			=> $_SESSION['event_data']['data'],
			"ingressos"		=> $_POST['ingresso'],
		);

		$_SESSION['event_data'] = $event;
	}

	if (isset($_SESSION['user_consumer'])) {

    	$id_producer 	= $_SESSION['user_consumer']['id'];
		$nome			= 'REVENDA: ' . $event['nome'];
		$descricao		= $event['descricao'];
		$categoria		= $event['categoria'];
		$capa			= $event['capa'];
		$cep			= $event['cep'];
		$bairro			= $event['bairro'];
		$cidade			= $event['cidade'];
		$estado			= $event['estado'];
		$rua			= $event['rua'];

		$data			= json_encode($event['data']);
		$event_data		= $event['data'][0];

		$ingressos		= json_encode($event['ingressos']);

		$query = "INSERT INTO events (tipo, business_id, banner, title, city, uf, local, description, days, ingressos, event_data)
			  	  VALUES (2, '$id_producer', '$capa', '$nome', '$cidade', '$estado', '$rua', '$descricao', '$data', '$ingressos', '$event_data')";

		if ($conn->query($query) === TRUE) {

			$id_evento = $conn->insert_id;
			header('Location: ../../evento/?id=' . $id_evento);

		} else {
			echo '<script>alert("#3192ND76SS | Erro ao executar a ação! Contacte o suporte.");</script>';
		}

	} else {

		echo '<script>alert("#3192ND76SS | Você deve estar logado(a) para publicar um ingresso.");</script>';	

	}

?>