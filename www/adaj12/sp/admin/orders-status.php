<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../database-config/OrdersAdminDB.php';
require_once __DIR__ . '/../database-config/UsersDB.php';

$ordersDB = new OrdersAdminDB();
$usersDB = new UsersDB();

if (isset($_POST['order_id'], $_POST['status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    $order = $ordersDB->findById($orderId);
    if ($order && $order['status'] !== $newStatus) {
        $ordersDB->updateStatus($orderId, $newStatus);
        $user = $usersDB->findById($order['user_id']);
        if ($user) {
            $to = $user['email'];
            $subject = "Změna stavu objednávky č. $orderId";
            $message = "Vážený zákazníku,\n\nstav Vaší objednávky č. $orderId byl změněn na: $newStatus.\n\nDěkujeme za Vaši objednávku.\nTým e-shopu";
            $headers = "From: adaj12@vse.cz";
            mail($to, $subject, $message, $headers);
        }
    }
}
header('Location: orders.php?edit=ok');
exit;
