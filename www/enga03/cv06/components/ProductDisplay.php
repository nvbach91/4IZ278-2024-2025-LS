<?php
require_once __DIR__ . '/../database/ProductsDB.php';

$productsDB = new ProductsDB();
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$products = $category_id ? $productsDB->fetchByCategory($category_id) : $productsDB->fetch();
?>

<div class="row">
  <?php foreach ($products as $product): ?>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100">
        <img class="card-img-top" src="<?php echo htmlspecialchars($product['img']); ?>" alt="Product image">
        <div class="card-body">
          <h4 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h4>
          <h5><?php echo number_format($product['price'], 2), ' Kč'; ?></h5>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>