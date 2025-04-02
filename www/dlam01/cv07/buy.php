<?php
require_once __DIR__ . '/database/GoodsDB.php';

$goodsDB = new GoodsDB();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$goodId = $_GET["id"];
$good = $goodsDB->fetchById($goodId);
if (!$good) {
    header("Location: index.php");
    exit;
}

session_start();
$_SESSION['cart'][] = $goodId;
header("Location: cart.php");
exit;
?>