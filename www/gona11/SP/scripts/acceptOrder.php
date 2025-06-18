<?php
    session_start();
    require_once __DIR__ . '/../database/DB_Scripts/OrderDB.php'; 

    $orderId = isset($_GET["id"]) ? (int)$_GET["id"] : null;

    if(!$orderId) {
        $_SESSION["updateStatusFailed"] = "Neplatný identifikátor objednávky. Zkontrolujte prosím odkaz.";
        header("Location: ./order.php?id=" . $orderId);
        exit();
    }

    $OrderDB = new OrderDB();

    $orderStatus = $OrderDB->getOrderStatus($orderId);
    if($orderStatus !== 1) {
        $_SESSION["updateStatusFailed"] = "Objednávka již byla zpracována.";
        header("Location: ../order.php?id=" . $orderId);
        exit();
    } else {
        $OrderDB->updateOrderStatus($orderId, 2);
        $_SESSION["updateStatusSuccess"] = "Objednávka byla úspěšně přijata.";
        header("Location: ../order.php?id=" . $orderId);
        exit();
    }
?>