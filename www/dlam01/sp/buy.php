<?php

require_once __DIR__ . '/database/ProductsDB.php';

$productsDB = new ProductsDB();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$productId = $_GET["id"];
$product = $productsDB->fetchById($productId);
if (!$product || $product['stock'] <= 0) {
    header("Location: index.php");
    exit;
}

session_start();
if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] = ["product" => $productId, "quantity" => 1];
}
else {
    $_SESSION['cart'][$productId] = ["product" => $productId, "quantity" => $_SESSION['cart'][$productId]['quantity'] + 1];
}
$productsDB->updateStock($productId, $product['stock'] - 1);
header("Location: cart.php");
exit;
