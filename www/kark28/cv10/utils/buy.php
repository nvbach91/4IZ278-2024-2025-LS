<?php
session_start();
if(!isset($_SESSION['name'])) {
    header('Location: ../login.php');
    exit();
  }
require __DIR__ . '/../database/ProductDB.php';
$productsDB = new ProductDB;
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$goods = $productsDB->findByID($_GET['product'])[0];
if (!$goods){
    exit("Unable to find goods!");
}
var_dump($goods["product_id"]);
$_SESSION['cart'][] = $goods["product_id"];
header('Location: ../cart.php');
exit();
?>