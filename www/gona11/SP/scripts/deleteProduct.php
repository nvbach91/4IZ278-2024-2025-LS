<?php 
    session_start();
    require_once __DIR__ . '/../database/DB_Scripts/ProductDB.php';

    $productId = isset($_GET["id"]) ? (int)$_GET["id"] : null;
    if(!$orderId) {
        $_SESSION["deleteFailed"] = "Neplatný identifikátor objednávky. Zkontrolujte prosím odkaz.";
        header("Location: ./order.php?id=" . $orderId);
        exit();
    }
?>