<?php
session_start();
if ($_SESSION['privilege'] < '2') {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../database/ProductsDB.php';
$productsDB = new ProductsDB();

if (!isset($_GET["id"])) {
    header("Location: ../index.php");
    exit;
}
$productId = $_GET["id"];
$product = $productsDB->fetchById($productId);
if (!$product) {
    header("Location: ../index.php");
    exit;
}

$productsDB->deleteById($productId);
header("Location: adminProducts.php");
exit;
