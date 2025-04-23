<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../database/DatabaseOperation.php';
require __DIR__ . '/../includes/header.php';

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<main class="container">
    <h1 class="my-4">Shopping Cart</h1>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($cartItems as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($item['img']); ?>" alt="Product image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($item['price']); ?> Kč</strong></p>
                            <a href="remove-item.php?good_id=<?php echo $item['good_id']; ?>" class="btn btn-danger">Remove</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>