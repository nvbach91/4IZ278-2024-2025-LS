<?php

require_once __DIR__ . '/database/ProductsDB.php';

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$productId = $_GET["id"];
$productsDB = new ProductsDB();
$product = $productsDB->fetchById($productId);

if (!$product) {
    header("Location: index.php");
    exit;
}

?>

<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product["image"]); ?>" alt="<?= htmlspecialchars($product["name"]); ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h1><?= htmlspecialchars($product["name"]); ?></h1>
            <p><?= htmlspecialchars($product["description"]); ?></p>
            <h4>Price: $<?= number_format($product["price"], 2); ?></h4>
            <h5>Stock: <?= htmlspecialchars($product["stock"]); ?></h5>
            <?php if ($product['stock'] <= 0): ?>
                  <a class="btn btn-secondary disabled" href="#">Out of stock</a>
                <?php else: ?>
                <a class="btn btn-primary" href="<?= './buy.php?id=' . $product["id"]; ?>">Add to cart</a>
                <?php endif; ?>
        </div>
    </div>  
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>