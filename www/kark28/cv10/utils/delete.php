<?php

require __DIR__ . '/../database/ProductDB.php';
$productsDB = new ProductDB;
$id = $_GET['id'];

$productsDB->delete($id);

header('Location: ../index.php');

?>