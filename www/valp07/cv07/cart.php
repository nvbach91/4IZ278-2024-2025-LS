<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();
$cartItems = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $sql = "SELECT * FROM cv07_goods WHERE good_id IN ($placeholders)";
    $stmt = $connection->prepare($sql);
    $stmt->execute($_SESSION['cart']);
    $cartItems = $stmt->fetchAll();
}
?>

<?php require 'incl/header.php'; ?>

<main class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="my-4">Shopping Cart</h1>

            <?php if (empty($cartItems)): ?>
                <div class="alert alert-info">
                    Your cart is empty. <a href="index.php">Continue shopping</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <h5><?php echo number_format($item['price'], 2), ' ', GLOBAL_CURRENCY; ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                                </div>
                                <div class="card-footer">
                                    <a href="remove-item.php?good_id=<?php echo $item['good_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mb-4">
                    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require 'incl/footer.php'; ?>