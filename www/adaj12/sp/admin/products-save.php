<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../database-config/ProductsAdminDB.php';
$productsDB = new ProductsAdminDB();

$data = [
    'name' => $_POST['name'] ?? '',
    'description' => $_POST['description'] ?? '',
    'detail' => $_POST['detail'] ?? '',
    'price' => $_POST['price'] ?? 0,
    'image' => $_POST['image'] ?? '',
    'stock' => $_POST['stock'] ?? 0,
    'min_age' => $_POST['min_age'] ?? 0,
    'max_age' => $_POST['max_age'] ?? 0,
    'tag' => $_POST['tag'] ?? '',
    'genre_id' => $_POST['genre_id'] ?? 0,
    'category_id' => $_POST['category_id'] ?? 0,
];

if (!empty($_POST['id'])) {
    $productsDB->update($_POST['id'], $data);
} else {
    $productsDB->create($data);
}

header('Location: products.php?edit=ok');
exit;
