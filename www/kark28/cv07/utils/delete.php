<?php
require __DIR__ . '/../database/ProductDB.php';
$productsDB = new ProductDB;
$id = $_GET['id'];

$sql = "DELETE FROM `products` WHERE product_id = $id";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

header('Location: ../index.php');

?>