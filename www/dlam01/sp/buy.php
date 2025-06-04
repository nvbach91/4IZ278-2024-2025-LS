<?php

require_once __DIR__ . '/database/ProductsDB.php';

$productsDB = new ProductsDB();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$productId = $_GET["id"];
$product = $productsDB->fetchById($productId);
if (!$product) {
    header("Location: index.php");
    exit;
}

session_start();
$_SESSION['cart'][] = $productId;
header("Location: cart.php");
exit;
