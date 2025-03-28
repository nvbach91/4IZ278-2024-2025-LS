<?php
require_once "classes/Product.php";
require_once "db/ProductDb.php";

$productDb = new ProductDb();


$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;


if ($category_id) {
    $products = $productDb->findByCategoryId($category_id);
} else {
    $products = $productDb->find();
}





foreach ($products as $product) {

    require 'ProductCard.php';
}
