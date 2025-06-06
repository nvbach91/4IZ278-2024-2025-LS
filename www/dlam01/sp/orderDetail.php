<?php

session_start();
require_once __DIR__ . '/database/OrdersDB.php';
require_once __DIR__ . '/database/OrderItemsDB.php';
require_once __DIR__ . '/database/ProductsDB.php';
require_once __DIR__ . '/database/ShippingDB.php';
require_once __DIR__ . '/database/UsersDB.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$orderId = (int)$_GET['id'];
$ordersDB = new OrdersDB();
$orderItemsDB = new OrderItemsDB();
$productsDB = new ProductsDB();
$shippingDB = new ShippingDB();
$usersDB = new UsersDB();

$order = $ordersDB->fetchById($orderId);
if (!$order) {
    header("Location: index.php");
    exit;
}
$user = $usersDB->fetchById($order['user_id']);
$shipping = $shippingDB->fetchById($order['shipping_method_id']);
$orderItems = $orderItemsDB->fetchByOrderId($orderId);

$products = [];
foreach ($orderItems as $item) {
    $product = $productsDB->fetchById($item['product_id']);
    if ($product) {
        $products[] = [
            'name' => $product['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity']
        ];
    }
}

?>

<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Order #<?= htmlspecialchars($orderId) ?></h1>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Shipping Address</h4>
            <p><strong>Name:</strong> <?= htmlspecialchars($user['firstName'] ?? '') . ' ' . htmlspecialchars($user['secondName'] ?? '') ?></p>
            <p><strong>Street:</strong> <?= htmlspecialchars($order['street']) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['zip_code']) ?></p>
            <p><strong>Shipping Method:</strong> <?= htmlspecialchars($shipping['name'] ?? '') ?> ($<?= number_format($shipping['price'] ?? 0, 2) ?>)</p>
            <p><strong>Order status:</strong> <?php switch ($order['status']) {
                                                    case 1:
                                                        echo "Order is being processed";
                                                        break;
                                                    case 2:
                                                        echo "Order has been confirmed";
                                                        break;
                                                    case 3:
                                                        echo "Order has been cancelled";
                                                        break;
                                                } ?></p>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Items</h4>
                <ul class="list-group">
                    <?php foreach ($orderItems as $item):
                        $product = $productsDB->fetchById($item['product_id']);
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?> (x<?= $item['quantity'] ?>)
                            <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Shipping</strong>
                        <span>$<?= number_format($shipping['price'] ?? 0, 2) ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">Total Price</h4>
                <p class="display-4 text-success">$<?= number_format($order['total_price'], 2) ?></p>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>