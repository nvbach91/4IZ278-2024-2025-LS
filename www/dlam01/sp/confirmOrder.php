<?php

session_start();
require_once __DIR__ . '/database/OrdersDB.php';
require_once __DIR__ . '/database/ShippingDB.php';
require_once __DIR__ . '/database/ProductsDB.php';
require_once __DIR__ . '/database/OrderItemsDB.php';

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit;
}

if (!isset($_SESSION["checkout_details"]) || !isset($_SESSION["shipping_method"])) {
    header("Location: checkout.php");
    exit;
}

$ordersDB = new OrdersDB();
$shippingDB = new ShippingDB();
$productsDB = new ProductsDB();
$OrderItemsDB = new OrderItemsDB();
$cartItems = [];
foreach ($_SESSION["cart"] as $id) {
    $item = $productsDB->fetchById($id);
    if ($item) {
        $cartItems[] = $item;
    }
}
$checkoutDetails = $_SESSION["checkout_details"];
$shippingMethod = $shippingDB->fetchById($_SESSION["shipping_method"]);
$totalPrice = $shippingMethod["price"];

foreach ($cartItems as $item) {
    $totalPrice += $item["price"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $orderId = $ordersDB->getHighestID() + 1;
    $ordersDB->insert($orderId, $_SESSION["user_id"], 1, $shippingMethod["id"], $shippingMethod["price"], $totalPrice, $checkoutDetails["city"], $checkoutDetails["street"], $checkoutDetails["zipCode"]);

   foreach ($cartItems as $item) {
        $OrderItemsDB->insert($orderId, $item["id"], 1, $item["price"]);
    }
    unset($_SESSION["cart"]);
    unset($_SESSION["checkout_details"]);
    unset($_SESSION["shipping_method"]);

    header("Location: orderSuccess.php");
    exit;
}

?>

<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Confirm Your Order</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">Shipping Address</h4>
            <div class="mb-3">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($checkoutDetails["firstName"] . " " . $checkoutDetails["secondName"]); ?></p>
                <p><strong>Street:</strong> <?php echo htmlspecialchars($checkoutDetails["street"]); ?></p>
                <p><strong>City:</strong> <?php echo htmlspecialchars($checkoutDetails["city"] . ", " . $checkoutDetails["zipCode"]); ?></p>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h4 class="card-title">Items in Cart</h4>
            <ul class="list-group">
                <?php foreach ($cartItems as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($item["name"]); ?>
                        <span>$<?php echo number_format($item["price"], 2); ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($shippingMethod["name"]); ?>
                        <span>$<?php echo number_format($shippingMethod["price"], 2); ?></span>
                    </li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
            <h4 class="card-title">Total Price</h4>
            <p class="display-4 text-success">$<?php echo $totalPrice ?></p>
            <form method="POST">
                <button type="submit" class="btn btn-success btn-lg">Place Order</button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>