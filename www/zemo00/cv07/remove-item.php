<?php

session_start();

$goodId = isset($_GET['good_id']) ? (int) $_GET['good_id'] : 0;

if ($goodId <= 0 || !isset($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($goodId) {
    return (int) $item['good_id'] !== $goodId;
});

$_SESSION['cart'] = array_values($_SESSION['cart']);

header('Location: cart.php');
exit;

?>