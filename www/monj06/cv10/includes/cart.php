<?php
include __DIR__ . '/header.php';


$isCartSet = !empty($_SESSION['boughtProducts']);

if ($isCartSet) {
    $cart = $_SESSION['boughtProducts'];
}
?>

<div class="row">
    <?php if ($isCartSet): ?>
        <?php foreach ($cart as $product): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 product">
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="#"><?php echo $product['name']; ?></a>
                        </h4>
                        <h5><?php echo number_format($product['price'], 2), ' ', '$'; ?></h5>
                        <p class="card-text">...</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                        <a href="/4IZ278/DU/du06//includes/remove-item.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-danger">Remove</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php';
