<?php require_once __DIR__ . '/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php require_once __DIR__.'/database/OrdersDB.php'; ?>
<?php require_once __DIR__.'/database/OrderItemsDB.php'; ?>
<?php include_once __DIR__.'/utils/Email.php'; ?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>
<?php require_once __DIR__ . '/utils/PDF.php'; ?>
<?php
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$productsDB = new ProductsDB();
$ordersDB = new OrdersDB();
$orderItemsDB = new OrderItemsDB();
$emailClient = new Email();
$log = AppLogger::getLogger();
$pdf = new PDF();
$isSetID = !empty($_POST['id']);

if($isSetID && $_POST['id'] == $_SESSION['user']['id']) {
    if (!$csrf->validateRequest('buy')) {
        echo 'Invalid CSRF token';
        http_response_code(403);
        $log->error('Invalid CSRF token on buy.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
        exit();
    }
    $orderId = $ordersDB->createOrder($_SESSION['user']['id']);
    $orderItemsDB->addItemsToOrder($orderId, $_SESSION['cart']);
    $emailClient->sendOrderSuccess($orderId);
    $log->info('Order created successfully', [
        'order_id' => $orderId,
        'user_id' => $_SESSION['user']['id'],
        'items' => $_SESSION['cart']
    ]);
    $order = $ordersDB->getOrderByOrderId($orderId);
    $pdf->generateInvoice(
        $_SESSION['user']['name'],
        $order['address'],
        $_SESSION['user']['phone'],
        $_SESSION['user']['email'],
        $orderId
    );
    $_SESSION['cart'] = [];
    header('Location: '.$urlPrefix.'/order_success.php?id=' . $orderId);
    exit;
} else {
    header('Location: '.$urlPrefix.'/index.php');
}

?>