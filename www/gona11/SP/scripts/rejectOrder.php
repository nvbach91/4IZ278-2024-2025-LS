<?php
    session_start();
    require_once __DIR__ . '/../database/DB_Scripts/OrderDB.php';  

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    $orderId = isset($_GET["id"]) ? (int)$_GET["id"] : null;

    if(!$orderId) {
        $_SESSION["updateStatusFailed"] = "Neplatný identifikátor objednávky. Zkontrolujte prosím odkaz.";
        header("Location: ./order.php?id=" . $orderId);
        exit();
    }

    if($loggedIn && $privilegeLevel > 1) {
        $orderDB = new OrderDB();

        $orderStatus = $orderDB->getOrderStatus($orderId);
        if($orderStatus !== 1) {
            $_SESSION["updateStatusFailed"] = "Objednávka již byla zpracována.";
            header("Location: ../order.php?id=" . $orderId);
            exit();
        } else {
            $orderDB->updateOrderStatus($orderId, 3);
            $_SESSION["updateStatusSuccess"] = "Objednávka byla úspěšně zamítnuta.";
            header("Location: ../order.php?id=" . $orderId);
            exit();
        }
    } else {
        $_SESSION["updateStatusFailed"] = "Nemáte oprávnění zamítnout objednávku.";
        header("Location: ../index.php");
        exit();
    }
?>