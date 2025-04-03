<?php
session_start();
require_once __DIR__ . '/db/ProductsDB.php';

if (!isset($_COOKIE['name']) || empty($_COOKIE['name'])) {
    header('Location: login.php');
    exit;
}

$userName = $_COOKIE['name'];
$cart = isset($_COOKIE[$userName]) ? json_decode($_COOKIE[$userName], true) : [];
if (!is_array($cart)) {
    $cart = [];
}

$productsDB = new ProductsDB();
$productsInCart = [];

foreach ($cart as $productId) {
    $product = $productsDB->getProductById($productId);
    if ($product) {
        $productsInCart[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>
        <?php if (empty($productsInCart)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($productsInCart as $product): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span>- <?php echo number_format($product['price'], 2), ' CZK'; ?></span>
                        </div>
                        <a href="remove-item.php?id=<?php echo $product['good_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-3">
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>