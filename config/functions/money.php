<?php 

	function toReceive($id, $conn) {

		$query = "SELECT SUM(tickets_saled.valor) AS total
				  FROM tickets_saled
				  INNER JOIN events ON events.id = tickets_saled.event_id
				  WHERE events.business_id = $id AND tickets_saled.status = 1 AND events.status = 1";

		$result = $conn->query($query);

		if ($result) {

		    $row = $result->fetch_assoc();
		    $total = $row['total'];
		    
			if ($total === null) { $total = 0; }
		    return $total;

		} else {

		    return 0;

		}

	}

function toWithdraw($id, $conn) {

	$query = "SELECT SUM(tickets_saled.valor) AS total
			  FROM tickets_saled
			  INNER JOIN events ON events.id = tickets_saled.event_id
			  WHERE events.business_id = $id AND tickets_saled.status = 1 AND events.status = 3";

	$result = $conn->query($query);

	if ($result && $result->num_rows > 0) {

	    $row = $result->fetch_assoc();
	    $total = $row['total'];
	    
		if ($total === null) { $total = 0; }
	    return $total;

	} else {

	    return 0;

	}

}

function calcLucro($valor, $taxa) {
	$lucro_em_reais = ($taxa / 100) * $valor;
	return $lucro_em_reais;
}

function descLucro($valor, $taxa) {
	$lucro_em_reais = ($taxa / 100) * $valor;
	$total_com_lucro_descontado = $valor - $lucro_em_reais;
	return $total_com_lucro_descontado;
}

?>