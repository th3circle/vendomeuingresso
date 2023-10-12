<?php 

	function getUserLocation() {

	    $ip = $_SERVER['REMOTE_ADDR'];

	    if ($ip == '::1') {

	    	return 'Localhost, LC';
	    	$_SESSION['city'] = 'Salvador';
	    	$_SESSION['uf'] = 'BA';

	    } elSe {
	
		    $ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

		    $city = isset($ipDetails->city) ? $ipDetails->city : 'Cidade Desconhecida';

			$stateMap = array(
			    'Acre' => 'AC',
			    'Alagoas' => 'AL',
			    'Amapá' => 'AP',
			    'Amazonas' => 'AM',
			    'Bahia' => 'BA',
			    'Ceará' => 'CE',
			    'Distrito Federal' => 'DF',
			    'Espírito Santo' => 'ES',
			    'Goiás' => 'GO',
			    'Maranhão' => 'MA',
			    'Mato Grosso' => 'MT',
			    'Mato Grosso do Sul' => 'MS',
			    'Minas Gerais' => 'MG',
			    'Pará' => 'PA',
			    'Paraíba' => 'PB',
			    'Paraná' => 'PR',
			    'Pernambuco' => 'PE',
			    'Piauí' => 'PI',
			    'Rio de Janeiro' => 'RJ',
			    'Rio Grande do Norte' => 'RN',
			    'Rio Grande do Sul' => 'RS',
			    'Rondônia' => 'RO',
			    'Roraima' => 'RR',
			    'Santa Catarina' => 'SC',
			    'São Paulo' => 'SP',
			    'Sergipe' => 'SE',
			    'Tocantins' => 'TO'
			);

		    $state = isset($ipDetails->region) ? $ipDetails->region : 'S/E';
		    $stateAbbreviation = isset($stateMap[$state]) ? $stateMap[$state] : 'S/E';

			ini_set('display_errors', 0);
			error_reporting(0);

		    return $city . ', ' . $stateAbbreviation;

	    }

	}

	function getUserCep() {

	    $ip = $_SERVER['REMOTE_ADDR'];
	    $ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

	    $cep = isset($ipDetails->postal) ? $ipDetails->postal : '';

	    return $cep;

	}

	function cepToCity($cep) {

	    $cepDetails = json_decode(file_get_contents("https://viacep.com.br/ws/{$cep}/json/"));
	    $city = $cepDetails->localidade;
	    $uf = $cepDetails->uf;
	    return $city . ', ' . $uf;

	}

?>