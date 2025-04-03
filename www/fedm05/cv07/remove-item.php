<?php
session_start();

if (isset($_GET['id']) && isset($_COOKIE['name']) && !empty($_COOKIE['name'])) {
    $productId = (int)$_GET['id'];
    $userName = $_COOKIE['name'];

    $cart = isset($_COOKIE[$userName]) ? json_decode($_COOKIE[$userName], true) : [];
    if (!is_array($cart)) {
        $cart = [];
    }
    if (($key = array_search($productId, $cart)) !== false) {
        unset($cart[$key]);
    }
    setcookie($userName, json_encode($cart), time() + 3600, '/');
    header('Location: cart.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
