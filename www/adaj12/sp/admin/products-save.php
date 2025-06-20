<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../database-config/ProductsAdminDB.php';
$productsDB = new ProductsAdminDB();

$requiredFields = [
    'name', 'description', 'detail', 'price', 'image', 'stock', 'min_age', 'max_age', 'tag', 'genre_id', 'category_id'
];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '' && $_POST[$field] !== '0') {
        header('Location: products.php?edit=error&message=Vyplňte všechna povinná pole.');
        exit;
    }
}

$data = [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'detail' => $_POST['detail'],
    'price' => $_POST['price'],
    'image' => $_POST['image'],
    'stock' => $_POST['stock'],
    'min_age' => $_POST['min_age'],
    'max_age' => $_POST['max_age'],
    'tag' => $_POST['tag'],
    'genre_id' => $_POST['genre_id'],
    'category_id' => $_POST['category_id'],
];

if (!empty($_POST['id'])) {
    $productsDB->update($_POST['id'], $data);
} else {
    $productsDB->create($data);
}

header('Location: products.php?edit=ok');
exit;
