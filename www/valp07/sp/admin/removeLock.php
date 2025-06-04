<?php

require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/ProductsDB.php';

session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$productId = $_GET['id'] ?? null;
if (!$productId || !is_numeric($productId)) {
    http_response_code(400);
    exit('Invalid product ID.');
}

$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);

$productsDB->unlockProduct($productId);

$referer = $_SERVER['HTTP_REFERER'] ?? 'products.php';
header("Location: $referer");
exit;
