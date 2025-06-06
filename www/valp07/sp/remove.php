<?php
require 'db/DatabaseConnection.php';
require 'db/CartItemsDB.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['id'];
$productId = $_GET['id'] ?? null;

if (!$productId || !is_numeric($productId)) {
    header('Location: cart.php');
    exit;
}

$connection = DatabaseConnection::getPDOConnection();
$cartsDB = new CartItemsDB($connection);

$cartsDB->deleteByUserAndProduct($userId, $productId);

header('Location: cart.php');
exit;