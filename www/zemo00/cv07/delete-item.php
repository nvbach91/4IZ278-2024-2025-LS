<?php
require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();

$goodId = isset($_GET['good_id']) ? (int)$_GET['good_id'] : 0;

if ($goodId <= 0) {
    die('Invalid product ID.');
}

$args = [
    'conditions' => ['good_id = :id'],
    'id' => $goodId
];

$goodsDB->delete($args);

header('Location: index.php');
exit;
?>