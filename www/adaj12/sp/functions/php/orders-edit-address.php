<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../../database-config/OrdersAdminDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $name = $_POST['shipping_name'] ?? '';
    $street = $_POST['shipping_street'] ?? '';
    $city = $_POST['shipping_city'] ?? '';
    $postal_code = $_POST['shipping_postal_code'] ?? '';

    $ordersDB = new OrdersAdminDB();
    $ordersDB->updateShippingAddress($orderId, $name, $street, $postal_code, $city);
    header("Location: ../../admin/orders.php?edit=ok");
    exit;
}
header("Location: ../../admin/orders.php");
exit;
