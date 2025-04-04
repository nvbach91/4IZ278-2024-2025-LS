<?php
session_start();

require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();

$goodId = isset($_GET['good_id']) ? (int)$_GET['good_id'] : 0;

if ($goodId <= 0) {
    die('Invalid good ID.');
}

$args = [
    'columns' => ["*"],
    'conditions' => ["good_id = $goodId"]
];

$good = $goodsDB->fetch($args)[0] ?? null;

if (!$good) {
    die('Product not found.');
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = $good;

header('Location: cart.php');
exit;
?>