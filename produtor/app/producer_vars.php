<?php 

	$config['cor_primaria'] = "#AFA4CE";
	$config['cor_secundaria'] = "#9186b0";

	$id_producer = $_SESSION['user_producer']['id'];
	$query = "SELECT * FROM producer WHERE id = '$id_producer'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($producer_data = mysqli_fetch_array($mysqli_query)) { $producer = $producer_data; }

	if ($producer['vinculo_tipo'] == 'Equipe' AND $page_name != 'Eventos') { header('Location: ' . $config['app_local'] . '/produtor/eventos'); }
	if ($producer['vinculo_tipo'] == 'Portaria' AND $page_name != 'Portaria') { header('Location: ' . $config['app_local'] . '/produtor/eventos'); }

	function checkPermission($theCan, $permission) {

		if ($permission == 'Equipe') {

			$can = [
				"can_view_events",
				"can_edit_events",
				"can_check_tickets",
			];

		} elseif ($permission == 'Admin') {

			$can = [
				"can_all",
			];

		} elseif ($permission == 'Portaria') {

			$can = [
				"can_view_events",
				"can_check_tickets",
			];

		}

		if (in_array($theCan, $can)) { return true; } elseif ($permission == 'Admin') { return true; } else { return false; }

	}

	function errorAlert($id, $conn) {

		$query = "SELECT * FROM producer WHERE id = '$id'";
		$mysqli_query = mysqli_query($conn, $query);
		while ($producer_data = mysqli_fetch_array($mysqli_query)) { $producer = $producer_data; }

		// verificacao de e-mail
		if ($producer['verify_email'] == 0) {

			$alert = array(
				"display" => "block",
				"target" => "_blank",
				"link" => "minha-conta",
				"msg" => "Verifique o seu e-mail!",
			);

		// info físcais
		} elseif (empty($producer['endereco_cep']) OR empty($producer['endereco_cidade']) OR empty($producer['endereco_estado']) OR empty($producer['endereco_longradouro'])) {
			
			$alert = array(
				"display" => "block",
				"target" => "_self",
				"link" => "minha-conta",
				"msg" => "Informações pendentes!",
			);

		// método de saque
		} elseif (empty($producer['met_saque']) OR $producer['met_saque'] == null) {
			
			$alert = array(
				"display" => "block",
				"target" => "_self",
				"link" => "ajustes/metodo-de-saque",
				"msg" => "Configure seu método de saque!",
			);

		}

		else { $alert = array('display' => 'none',); }

		return $alert;
	}

?>