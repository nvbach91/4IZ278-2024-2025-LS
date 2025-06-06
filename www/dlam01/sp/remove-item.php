<?php

session_start();
require_once __DIR__ . '/database/ProductsDB.php';

$productsDB = new ProductsDB();
if(!isset($_GET["id"])){header("Location: cart.php");}
$product = $productsDB->fetchById($_GET["id"]);
    $id = $_GET["id"];
    if(isset($_SESSION["cart"][$id])){
        if($_SESSION["cart"][$id]['quantity'] > 1){
            $_SESSION["cart"][$id]['quantity']--;
        } else {
            unset($_SESSION["cart"][$id]);
        }
    }

$productsDB->updateStock($id, $product['stock'] + 1);
header("Location: cart.php");
exit;
?>