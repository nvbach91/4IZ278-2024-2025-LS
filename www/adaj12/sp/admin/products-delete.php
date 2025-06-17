<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../database-config/ProductsAdminDB.php';
$productsDB = new ProductsAdminDB();

if (isset($_POST['id'])) {
    $productsDB->delete($_POST['id']);
}
header('Location: products.php?edit=ok');
exit;
