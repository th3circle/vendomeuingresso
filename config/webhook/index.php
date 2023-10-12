<?php

    $page_name = "webhook";

    require "../conn.php";
    require "../geral.php";
    require "../../vendor/autoload.php";

    $webhookData = file_get_contents("php://input");
    
    $webhookData = json_decode($webhookData, true);
    $action = $webhookData['action'];
    
    if ($action == 'payment.created') {
    
        $access_token = $config['mp_access_token'];
        $payment_id = $webhookData['data']['id'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/{$payment_id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        
        $headers = array(
            'Authorization: Bearer ' . $access_token
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            
            echo 'Erro na requisição: ' . curl_error($ch);
            
        } else {
            
            $payment_data = json_decode($result, true);
        
            if ($payment_data['status'] == 'approved') {
                
                $id = $payment_data['external_reference'];
                
                $query = "UPDATE tickets_saled SET status = 1 WHERE tk_code = '$id'";
                $conn->query($query);
                
                $query = "INSERT INTO webhooks (data) VALUES ('aprovado')";
                $conn->query($query);
                

                // ENVIAR EMAIL

                // ticket
                $query = "SELECT * FROM tickets_saled WHERE tk_code = '$id' LIMIT 1";
                $mysqli_query = mysqli_query($conn, $query);
                while ($ticket_data = mysqli_fetch_array($mysqli_query)) { $ticket = $ticket_data; }

                // user
                $user_id = $ticket['user_id'];
                $query = "SELECT * FROM users WHERE id = '$user_id'";
                $mysqli_query = mysqli_query($conn, $query);
                while ($user_data = mysqli_fetch_array($mysqli_query)) { $user = $user_data; }

                // ticket
                $event_id = $ticket['event_id'];
                $query = "SELECT * FROM events WHERE id = '$event_id'";
                $mysqli_query = mysqli_query($conn, $query);
                while ($event_data = mysqli_fetch_array($mysqli_query)) { $event = $event_data; }

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;

                $body = file_get_contents('../emails/vendaAprovada.php');

                $mail = new PHPMailer(true);

                try {

                    $mail->isSMTP();
                    $mail->Host       = $config['smtp_host'];
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $config['smtp_user'];
                    $mail->Password   = $config['smtp_pass'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = $config['smtp_port'];

                    $mail->setFrom($config['smtp_user'], $config['app_name']);
                    $mail->addAddress($user['email'], $user['nome']);

                    $mail->isHTML(true);
                    $mail->Subject = utf8_decode($config['app_name'] . ': ' . $event['title']);

                    ob_start();
                    $nome_cliente = $user['nome'];
                    $nome_evento = $event['title'];
                    include('../emails/vendaAprovada.php');
                    $body = ob_get_clean();

                    $mail->Body = $body;

                    $mail->send();

                    http_response_code(200);
                    echo 'Pagamento aprovado';

                } catch (Exception $e) {



                }
                

                // ENVIAR WPP
                
            } else {
                
                // http_response_code(400);
                $result = 'Pagamento não aprovado ' . $payment_data['external_reference'] . ' - ' . date('d/m/Y h:i');
                
                $query = "INSERT INTO webhooks (data) VALUES ('$result')";
                $conn->query($query);
                
            }
            
        }
        
        curl_close($ch);
        
    }
    
    if ($action == 'resource') {
        
        $query = "INSERT INTO webhooks (data) VALUES ('entrou no primeiro if')";
        $conn->query($query);
        
        $access_token = $config['mp_access_token'];

        $payment_data = json_decode($result, true);
        $link = $payment_data['resource'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        
        $headers = array(
            'Authorization: Bearer ' . $access_token
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            
            $query = "INSERT INTO webhooks (data) VALUES ('erro na requisição')";
            $conn->query($query);
            
        } else {
            
            $payment_data = json_decode($result, true);
        
            if ($payment_data['status'] == 'approved') {
                
                http_response_code(200);
                echo 'Pagamento aprovado';
                
                $id = $payment_data['external_reference'];
                
                $query = "UPDATE tickets_saled SET status = 1 WHERE tk_code = '$id'";
                $conn->query($query);
                
                $query = "INSERT INTO webhooks (data) VALUES ('aprovado')";
                $conn->query($query);
                
                // ENVIAR EMAIL
                
                
                // ENVIAR WPP
                
            } else {
                
                // http_response_code(400);
                $result = 'Pagamento não aprovado ' . $payment_data['external_reference'] . ' - ' . date('d/m/Y h:i');
                
                $query = "INSERT INTO webhooks (data) VALUES ('$result')";
                $conn->query($query);
                
            }
            
        }
        
        curl_close($ch);
        
    }

?>