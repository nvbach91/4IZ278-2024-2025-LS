<?php
session_start();
require_once __DIR__ . '/database/DatabaseOperation.php';

if (isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];

    $dbOps = new DatabaseOperation();
    $item = $dbOps->fetchGoodById($good_id);

    if ($item) {
        // add item session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $good_id;

        header('Location: pages/cart.php');
        exit;
    } else {
        echo "Error: Item does not exist.";
    }
} else {
    echo "Error: No item ID provided.";
}
?>