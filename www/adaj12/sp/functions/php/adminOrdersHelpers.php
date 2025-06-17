<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../../database-config/OrdersAdminDB.php';
$ordersDB = new OrdersAdminDB();

// Změna statusu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];
    $ordersDB->updateStatus($orderId, $status);
    header("Location: orders.php?edit=ok"); exit;
}

// Výpis objednávek
$orders = $ordersDB->fetchAllWithUser();
