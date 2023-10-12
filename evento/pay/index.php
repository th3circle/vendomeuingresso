<?php $page_name = 'Pagar';

require "../../config/conn.php";
require "../../config/geral.php";

if (!isset($_SESSION['pay_data']) OR empty($_SESSION['pay_data'])) { header('Location: ' . $config['$app_local'] . '#'); }

$id = $_SESSION['pay_data']['id'];
$query = "SELECT * FROM events WHERE id = '$id'";
$mysql_query = mysqli_query($conn, $query);
while ($evento = mysqli_fetch_array($mysql_query)) { $event = $evento; }

// ===========================================================
// ==================  insercao no db de tickets_saled  ======

$user_id    = $_SESSION['user_consumer']['id'];
$data       = $_SESSION['pay_data']['dia'];
$event_id   = $event['id'];

$tk_code = rand(000001,999999);

$ticket_count = count($_SESSION['pay_data']['ticket']);
$loop_counter = 0;

if (!isset($_SESSION['pay_data']['session_control'])) {
    foreach ($_SESSION['pay_data']['ticket'] as $tipo => $ticket) {

        if (++$loop_counter === $ticket_count) {
            $_SESSION['pay_data']['session_control'] = session_id() . '_' . rand(0000000001,9999999999);
        }

        $nome_ticket = $tipo . ': ' . $event['title'] . ' | ' . date('d/m/Y', strtotime($data));
        $qntd_ticket = $ticket['qntd'];
        $valor_ticket = $qntd_ticket * $ticket['valor'];
        $valor_un = $ticket['valor'];

        $query = "INSERT INTO tickets_saled (user_id, event_id, tk_code, ticket, tipo, valor_un, valor, qntd) VALUES ('$user_id', '$event_id', '$tk_code', '$nome_ticket', '$tipo', '$valor_un', '$valor_ticket', '$qntd_ticket')";
        if ($qntd_ticket >= 1) { $conn->query($query); }
        
    }
}

// ===========================================================
// ===========================================================

$access_token = $config['mp_access_token'];

require_once "../../vendor/autoload.php";

MercadoPago\SDK::setAccessToken($access_token);

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = $event['title'] . ' | ' . date('d/m/Y', strtotime($data));
$item->quantity = 1;
$item->unit_price = $_SESSION['pay_data']['valor_total'];
$preference->items = array($item);

$preference->back_urls = array(
    "success" => 'https://vendomeuingresso.com/c/meus-ingressos',
    "failure" => 'https://vendomeuingresso.com',
    "pending" => 'https://vendomeuingresso.com'
);

$preference->auto_return = "approved";

$preference->notification_url = 'https://vendomeuingresso.com/config/webhook/index.php?id=passoget';
$preference->external_reference = $tk_code;
$preference->save();

$link = $preference->init_point;

header('Location: ' . $link);

?>