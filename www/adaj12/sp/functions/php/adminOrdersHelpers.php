<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../../database-config/OrdersAdminDB.php';
require_once __DIR__ . '/../../database-config/UsersDB.php';
require_once __DIR__ . '/../../database-config/ProductsDB.php';

$ordersDB = new OrdersAdminDB();
$usersDB = new UsersDB();
$productsDB = new ProductsDB();

// Změna statusu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];
    $order = $ordersDB->findById($orderId);
    if ($order && $order['status'] !== $status) {
        $ordersDB->updateStatus($orderId, $status);
        $user = $usersDB->findById($order['user_id']);
        if ($user) {
            $to = $user['email'];
            $subject = "Změna stavu objednávky č. $orderId";
            $message = "Vážený zákazníku,\n\nstav Vaší objednávky č. $orderId byl změněn na: $status.\n\nDěkujeme za Vaši objednávku.\nTým e-shopu";
            $headers = "From: adaj12@vse.cz";
            mail($to, $subject, $message, $headers);
        }
    } else {
        $ordersDB->updateStatus($orderId, $status);
    }
    header("Location: orders.php?edit=ok"); exit;
}

// Výpis objednávek
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$totalOrders = $ordersDB->countAll();
$totalPages = ceil($totalOrders / $limit);

$orders = $ordersDB->fetchPageWithUser($limit, $offset);

// Načtení položek k objednávkám (produkty)
foreach ($orders as &$order) {
    $order['items'] = [];
    $orderItems = $ordersDB->getOrderItems($order['id']);
    foreach ($orderItems as $item) {
        $order['items'][] = [
            'product_name' => $item['name'],
            'quantity' => $item['quantity'],
        ];
    }
}
unset($order);
