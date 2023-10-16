<?php

require "../config/conn.php";

require "../config/geral.php";
require "../config/cdn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["event_id"])) {
    	
        $eventId = $_POST["event_id"];

        $query = "UPDATE events SET clickCount = clickCount + 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $eventId);

        if ($stmt->execute()) {
            echo "Compartilhamento registrado com sucesso.";
        } else {
            echo "Erro ao registrar o compartilhamento.";
        }

        $stmt->close();

    } else {

        echo "ID do evento não fornecido.";
    }
} else {

    echo "Método de requisição inválido.";
}
?>