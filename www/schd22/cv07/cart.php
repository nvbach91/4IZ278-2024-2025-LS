<?php
session_start();
require_once __DIR__ . '/database/ProductDB.php';

$productsDB = new ProductDB();
$cartItems = $_SESSION['cart'] ?? [];

$productsInCart = $productsDB->findByIds($cartItems);

if (!empty($cartItems)) {
    // Odstraníme duplicity (nebo ponecháme podle potřeby)
    $uniqueIds = array_unique($cartItems);
    $productsInCart = $productsDB->findByIds($uniqueIds);
}

$totalPrice = 0;
foreach ($productsInCart as $product) {
    $count = $cartItems[$product['product_id']] ?? 0;
    $totalPrice += $product['price'];
}

?>

<?php require_once 'incl/header.php'; ?>

<div class="container mt-4">
  <h2>Cart value: <?php echo $totalPrice . ' ' . GLOBAL_CURRENCY; ?> </h2>

  <?php if (empty($productsInCart)): ?>
    <div class="alert alert-info">Košík je prázdný.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($productsInCart as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100">
            <img class="card-img-top" src="<?php echo htmlspecialchars($product['img']); ?>" alt="">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
              <p><strong><?php echo number_format($product['price'], 2) . ' ' . GLOBAL_CURRENCY; ?></strong></p>
              <a href="remove-item.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-danger">Odebrat</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

