<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$productId = $_GET['id'] ?? null;
if (!$productId || !is_numeric($productId)) {
    header('Location: products.php');
    exit;
}

$pdo = (new Database())->getConnection();
$stmt = $pdo->prepare("UPDATE products SET deactivated = 0 WHERE id = ?");
$stmt->execute([$productId]);

header('Location: products.php');
exit;