<?php
require_once __DIR__ . '/../requireAdmin.php';
session_start();
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/ProductsDB.php';


$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);


$requiredFields = ['id', 'name', 'description', 'brand', 'price', 'stock'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        die("Missing required field: $field");
    }
}

$product = [
    'id' => (int) $_POST['id'],
    'name' => trim($_POST['name']),
    'description' => trim($_POST['description']),
    'brand' => trim($_POST['brand']),
    'price' => (float) $_POST['price'],
    'stock' => (int) $_POST['stock'],
    'image' => trim($_POST['image']),
];

if (!empty($_POST['image'])) {
    $product['image'] = trim($_POST['image']);
}


$productsDB->editProduct($product);
$productsDB->unlockProduct($product['id']);
header('Location: products.php');
exit;
