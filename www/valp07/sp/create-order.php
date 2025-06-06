<?php
require 'db/DatabaseConnection.php';
require 'db/OrdersDB.php';
require 'db/OrderItemsDB.php';
require 'db/CartItemsDB.php';
require 'db/ProductsDB.php';
require 'db/AddressesDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();
$ordersDB = new OrdersDB($connection);
$orderItemsDB = new OrderItemsDB($connection);
$cartsDB = new CartItemsDB($connection);
$productsDB = new ProductsDB($connection);
$addressesDB = new AddressesDB($connection);

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
    'user_id' => $_SESSION['id'],
    'status' => 'pending',
    'payment_method' => $_POST['payment_method'],
    'address1' => $_POST['address1'],
    'address2' => $_POST['address2'] ?? null,
    'address3' => $_POST['address3'] ?? null,
    'city' => $_POST['city'],
    'state' => $_POST['state'],
    'county' => $_POST['county'] ?? null,
    'postal_code' => $_POST['postal_code'],
    'payment_method' => $paymentMethod,
    'created_at' => date('Y-m-d H:i:s'),
]);
if (!empty($_POST['save_address'])) {
    $addressesDB->saveOrUpdateUserAddress($userId, [
        'address1' => $_POST['address1'],
        'address2' => $_POST['address2'],
        'address3' => $_POST['address3'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'county' => $_POST['county'],
        'postal_code' => $_POST['postal_code'] // stačí jen id
    ]);
}
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
