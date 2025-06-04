<?php
require 'db/DatabaseConnection.php';
require 'db/OrdersDB.php';
require 'db/OrderItemsDB.php';
require 'db/CartItemsDB.php';
require 'db/ProductsDB.php';

session_start();

$connection = DatabaseConnection::getPDOConnection();
$ordersDB = new OrdersDB($connection);
$orderItemsDB = new OrderItemsDB($connection);
$cartsDB = new CartItemsDB($connection);
$productsDB = new ProductsDB($connection);

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    die("User not logged in.");
}

$paymentMethod = $_POST['payment_method'] ?? '';
$shippingAddress = $_POST['address'] ?? '';

$cartItems = $cartsDB->findCartItemsByUserID($userId);
if (empty($cartItems)) {
    die("Cart is empty.");
}
$orderId = $ordersDB->create([
    'user_id' => $userId,
    'status' => 'pending',
    'shipping_address' => $shippingAddress,
    'payment_method' => $paymentMethod,
    'created_at' => date('Y-m-d H:i:s'),
]);

foreach ($cartItems as $item) {
    $product = $productsDB->findProductByID($item['product_id']);
    $orderItemsDB->create([
        'order_id' => $orderId,
        'product_id' => $item['product_id'],
        'quantity' => $item['quantity'],
        'price' => $product['price'],
    ]);
}

$cartsDB->deleteByUser($userId);
header("Location: profile.php");
exit;
