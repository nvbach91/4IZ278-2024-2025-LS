<?php
require_once __DIR__ . '/../database/ProductsDB.php';
session_start();
if ($_SESSION['privilege'] < 2) {
    echo 'Unauthorized access';
    exit;
} else {
    $productsDB = new ProductsDB();
    $productsDB->delete($_GET['good_id']);
    header('Location: /4IZ278/DU/du06/index.php');
    exit();
}
