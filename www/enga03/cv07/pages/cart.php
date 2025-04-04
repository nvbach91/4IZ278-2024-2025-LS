<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../database/DatabaseOperation.php';
require __DIR__ . '/../incl/header.php';

$dbOps = new DatabaseOperation();
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$goods = [];

if (!empty($cartItems)) {
    foreach ($cartItems as $good_id) {
        $good = $dbOps->fetchGoodById($good_id);
        if ($good) {
            $goods[] = $good;
        }
    }
}
?>

<main class="container">
    <h1 class="my-4">Shopping Cart</h1>
    <?php if (empty($goods)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($goods as $good): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($good['img']); ?>" alt="Product image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($good['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($good['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($good['price']); ?> Kč</strong></p>
                            <a href="remove-item.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-danger">Remove</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../incl/footer.php'; ?>