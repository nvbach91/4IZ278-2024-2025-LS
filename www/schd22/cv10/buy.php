<?php
session_start();
require_once __DIR__ . '/database/ProductDB.php';

$productsDB = new ProductDB();

if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die('Neplatné ID zboží.');
}

$goodId = (int) $_GET['product_id'];
$product = $productsDB->findBy('product_id', $goodId);

if (!$product || count($product) === 0) {
    die('Zboží neexistuje.');
}

// Přidej do košíku v $_SESSION
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = $goodId;

// Přesměruj na cart.php
header('Location: cart.php');
exit();
