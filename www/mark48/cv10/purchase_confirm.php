<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ověříme, zda je uživatel přihlášen (session 'name' musí být nastavena)
if (!isset($_SESSION['name'])) {
    die("Uživatel není přihlášen. Prosím, přihlaste se.");
}

// Zkontrolujeme, zda byl předán parametr id produktu
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Nebyl poskytnut parametr id produktu.");
}

$productId = intval($_GET['id']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = $productId;


$_SESSION['cart'] = array_unique($_SESSION['cart']);

header("Location: cart.php");
exit;
