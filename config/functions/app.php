<?php 

	function route($routeName) {
	    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
	    $fullUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    $urlParts = parse_url($fullUrl);

	    // Obter o diretório do script em execução
	    $scriptDir = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);

	    // Montar a URL base
	    $baseUrl = $protocol . '://' . $urlParts['host'] . $scriptDir . '/';
	    $appLocal = $baseUrl;

	    return $appLocal . $routeName;
	}

	function isMobileDevice() {
	    return preg_match("/(android|blackberry|iphone|ipod|palm|pocket|symbian|windows ce|windows phone|mobile)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	function dateHour($hour) {
		return date('h:i', strtotime($hour));
	}

	function fullMonth($event_data) {
	    $event_timestamp = strtotime($event_data);

	    $meses = array(
	        1 => 'Janeiro',
	        2 => 'Fevereiro',
	        3 => 'Março',
	        4 => 'Abril',
	        5 => 'Maio',
	        6 => 'Junho',
	        7 => 'Julho',
	        8 => 'Agosto',
	        9 => 'Setembro',
	        10 => 'Outubro',
	        11 => 'Novembro',
	        12 => 'Dezembro'
	    );

	    $format = date('d \d\e ', $event_timestamp) . $meses[date('n', $event_timestamp)] . date(' \d\e Y', $event_timestamp);
	    return $format;
	}

	function dayToName($dataHora) {
	    $nomeDia = date('l', $dataHora);
	    switch ($nomeDia) {
	        case 'Monday':
	            return 'Segunda';
	        case 'Tuesday':
	            return 'Terça';
	        case 'Wednesday':
	            return 'Quarta';
	        case 'Thursday':
	            return 'Quinta';
	        case 'Friday':
	            return 'Sexta';
	        case 'Saturday':
	            return 'Sábado';
	        case 'Sunday':
	            return 'Domingo';
	        default:
	            return 'Dia inválido';
	    }
	}

	function monthToPT($nomeMesAbreviado) {
	    $nomesMeses = array(
	        'Jan' => 'Jan',
	        'Feb' => 'Fev',
	        'Mar' => 'Mar',
	        'Apr' => 'Abr',
	        'May' => 'Mai',
	        'Jun' => 'Jun',
	        'Jul' => 'Jul',
	        'Aug' => 'Ago',
	        'Sep' => 'Set',
	        'Oct' => 'Out',
	        'Nov' => 'Nov',
	        'Dec' => 'Dez'
	    );

	    return $nomesMeses[$nomeMesAbreviado];
	}

	function validaCPF($cpf) {

	    $cpf = preg_replace('/[^0-9]/', '', $cpf);

	    if (strlen($cpf) != 11) { return false; }
	    if (preg_match('/(\d)\1{10}/', $cpf)) { return false; }

	    $sum = 0;
	    for ($i = 0; $i < 9; $i++) { $sum += ($cpf[$i] * (10 - $i)); }
	    $remainder = $sum % 11;
	    $digit1 = ($remainder < 2) ? 0 : (11 - $remainder);

	    $sum = 0;
	    for ($i = 0; $i < 10; $i++) { $sum += ($cpf[$i] * (11 - $i)); }
	    $remainder = $sum % 11;
	    $digit2 = ($remainder < 2) ? 0 : (11 - $remainder);

	    if ($cpf[9] == $digit1 && $cpf[10] == $digit2) { return true; } else { return false; }
	    
	}

	function statusConvert($status) {

		if ($status == 0) {

			$status_data = array(
				"stats" => "processing",
				"color" => "#0000fa",
				"icon" => "fa-solid fa-clock",
				"message" => "PROCESSANDO",
			);

			return $status_data;

		} elseif ($status == 1) {

			$status_data = array(
				"stats" => "approved",
				"color" => "#00a13b",
				"icon" => "fa-solid fa-circle-check",
				"message" => "APROVADO",
			);

			return $status_data;

		} elseif ($status == 2) {

			$status_data = array(
				"stats" => "denied",
				"color" => "#ff672d",
				"icon" => "fa-solid fa-triangle-exclamation",
				"message" => "NEGADO",
			);

			return $status_data;

		} elseif ($status == 3) {

			$status_data = array(
				"stats" => "error",
				"color" => "#161617",
				"icon" => "fa-solid fa-circle-xmark",
				"message" => "ERRO",
			);

			return $status_data;

		} else {

			return null;

		}

	}

	function calcularEstoque($ingresso, $event_id, $ticketsSaled) {

	    $dataIngresso = array_key_first($ingresso);
	    $estoqueAtual = $ingresso['estoque'];
	    $tipoIngresso = $ingresso['tipo'];

	    foreach ($ticketsSaled AS $id => $tick) {

	    	$ingressosDb = json_decode($tick['json'], true);
	    	$tipo = $ingressosDb['tipo'];
	    	$qntd = $ingressosDb['qntd'];

	        if ($dataIngresso == $data AND $tipoIngresso == $tipo) {
	            $estoqueAtual -= $qntd;
	        }

	    }

	    if ($estoqueAtual == null) {
	    	$estoqueAtual = $ingresso['estoque'];
	    }

	    return $estoqueAtual;
	}

	function barcode($code) {
		return "https://api.invertexto.com/v1/barcode?token=4975%7CdXJm1hhZmZpdvtEr61zdpm9Y5jjGbzDl&text=".$code."&type=code39&font=0";
	}


?>

<!-- 0 = processamento | #0000fa | processing -->
<!-- 1 = aprovado | #02cf4d -->
<!-- 2 = negado | #f23a02 | denied -->
<!-- 3 = error | #161617 -->