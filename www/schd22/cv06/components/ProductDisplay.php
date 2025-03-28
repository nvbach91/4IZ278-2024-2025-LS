<?php require_once __DIR__ . '/../database/ProductDB.php'; ?>

<?php
$productsDB = new ProductDB();
$products = isset($_GET['category_id'])
  ? $productsDB->findByCategory($_GET['category_id'])
  : $productsDB->find();
?>

<div class="row">
  <?php foreach($products as $product): ?>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100">
        <a href="#">
          <img 
            class="card-img-top" 
            src="<?php echo htmlspecialchars($product['img']); ?>" 
            alt="<?php echo htmlspecialchars($product['name']); ?>">
        </a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#" class="product-name"> 
              <?php echo htmlspecialchars($product['name']); ?>
            </a>
          </h4>
          <h5 class="product-price">
            <?php echo number_format($product['price'], 2), ' ', GLOBAL_CURRENCY; ?>
          </h5>
          <p class="card-text">
            Lorem ipsum dolor amet sungo motte balu kareso loqes
          </p>
        </div>
        <div class="card-footer">
          <small class="text-muted rating-stars">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
