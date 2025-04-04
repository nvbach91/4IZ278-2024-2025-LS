<?php
require_once __DIR__ . '/database/ProductDB.php';

if (!isset($_GET['good_id']) || !is_numeric($_GET['good_id'])) {
    die('Neplatné ID.');
}

$goodId = (int) $_GET['good_id'];

$productsDB = new ProductDB();
$productsDB->delete($goodId);

header('Location: index.php');
exit();
?>