<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
require 'db/UsersDB.php';
require 'db/PhonesDB.php';
require 'db/CartItemsDB.php';
session_start();
$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);
$usersDB = new UsersDB($connection);
$cartsDB = new CartItemsDB($connection);

$userId = $_SESSION['id'];
$productId = $_GET['id'];
$quantity = $_POST['quantity'] ?? 1;
$existingCartItem = $cartsDB->findByUserAndProduct($userId, $productId);
if ($existingCartItem) {
    $newQuantity = (int)$quantity;
    $cartsDB->editCart([
        'id' => $existingCartItem['id'],
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $newQuantity,
    ]);
} else {
    $cartsDB->create([
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => (int)$quantity,
    ]);
}

header('Location: cart.php');
