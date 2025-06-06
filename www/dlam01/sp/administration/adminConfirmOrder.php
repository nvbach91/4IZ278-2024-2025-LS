<?php

session_start();
if ($_SESSION['privilege'] < '3') {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../database/OrdersDB.php';
$ordersDB = new OrdersDB();

if (!isset($_GET["id"])) {
    header("Location: ../index.php");
    exit;
}
$order = $ordersDB->fetchById($_GET["id"]);
if (!$order) {
    header("Location: ../index.php");
    exit;
}

$ordersDB->setStatusById($order['id'], 2);
header("Location: adminOrders.php");
exit;
?>