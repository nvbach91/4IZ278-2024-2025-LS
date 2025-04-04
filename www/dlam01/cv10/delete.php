<?php

session_start();
if ($_SESSION['privilege'] < '2') {
    header("Location: index.php");
    exit;
}

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

$goodsDB->deleteById($goodId);
header("Location: index.php");
exit;
?>