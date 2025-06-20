<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../database-config/ProductsAdminDB.php';
require_once __DIR__ . '/../database-config/OrdersDB.php';

$productsDB = new ProductsAdminDB();
$ordersDB = new OrdersDB();

if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    $stmt = $ordersDB->getPdo()->prepare("SELECT COUNT(*) FROM order_items WHERE game_id = ?");
    $stmt->execute([$productId]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        header('Location: products.php?error=Produkt již byl objednán a nelze jej smazat.');
        exit;
    }
    $productsDB->delete($productId);
}
header('Location: products.php?edit=ok');
exit;
