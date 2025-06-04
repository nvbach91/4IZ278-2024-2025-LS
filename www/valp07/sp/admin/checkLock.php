<?php
require_once __DIR__ . '/../requireAdmin.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/ProductsDB.php';



$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);

$productId = $_GET['id'] ?? null;
$userId = $_SESSION['id'] ?? null;

if (!$productId || !is_numeric($productId)) {
    http_response_code(400);
    exit('Invalid product ID.');
}

if (!$userId) {
    http_response_code(401);
    exit('You must be logged in.');
}

$product = $productsDB->getLockInfo($productId);

if (!$product) {
    http_response_code(404);
    exit('Product not found.');
}

$isLocked = false;

if (!empty($product['locked_by']) && !empty($product['locked_at'])) {
    $lockedAt = new DateTime($product['locked_at']);
    $now = new DateTime();
    $interval = $now->getTimestamp() - $lockedAt->getTimestamp();

    if ($interval < 1800 && $product['locked_by'] != $userId) {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/products.php';
        if (strpos($referer, 'product.php') !== false || strpos($referer, 'checkLock.php') !== false) {
            $referer = '/admin/products.php';
        }
        header("Location: $referer");
        exit;
    }
}

$productsDB->lockProduct($productId, $userId);
