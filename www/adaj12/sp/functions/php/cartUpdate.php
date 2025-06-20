<?php
session_start();
header('Content-Type: application/json');

$status = 'ok';
$total = 0;
$itemSubtotal = 0;
$empty = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $id = intval($_POST['remove']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $id = intval($id);
        $qty = max(1, intval($qty));
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    $ids = array_keys($_POST['quantity']);
    $currentId = intval($ids[0]);
    require_once __DIR__ . '/../../database-config/ProductsDB.php';
    $productsDB = new ProductsDB();
    $item = $productsDB->getByIds([$currentId]);
    if ($item && isset($_SESSION['cart'][$currentId])) {
        $itemSubtotal = number_format($item[0]['price'] * $_SESSION['cart'][$currentId], 2, ',', ' ');
    }
}

if (!empty($_SESSION['cart'])) {
    require_once __DIR__ . '/../../database-config/ProductsDB.php';
    $productsDB = new ProductsDB();
    $products = $productsDB->getByIds(array_keys($_SESSION['cart']));
    foreach ($products as $product) {
        $total += $product['price'] * $_SESSION['cart'][$product['id']];
    }
    $total = number_format($total, 2, ',', ' ');
} else {
    $empty = true;
}

echo json_encode([
    'status' => $status,
    'total' => $total,
    'itemSubtotal' => $itemSubtotal,
    'empty' => $empty
]);
exit;
