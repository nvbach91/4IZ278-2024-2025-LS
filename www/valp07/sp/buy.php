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

$userId = $_SESSION['id'] ?? null;
$productId = $_GET['id'] ?? null;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
$source = $_POST['source'] ?? 'buy';

if (!$userId || !$productId || !is_numeric($productId)) {
    header('Location: login.php');
    exit;
}

$existingCartItem = $cartsDB->findByUserAndProduct($userId, $productId);

if ($existingCartItem) {
    if ($source === 'cart') {
        $newQuantity = $quantity;
    } else {
        $newQuantity = $existingCartItem['quantity'] + $quantity;
    }

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
        'quantity' => $quantity,
    ]);
}

header('Location: cart.php');
exit;
