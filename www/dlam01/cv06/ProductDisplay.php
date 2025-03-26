<?php require_once __DIR__ . '/database/ProductsDB.php'; ?>
<?php
if (isset($_GET["category_id"])) {
  $category = $_GET["category_id"];
  $productsDB = new ProductsDB();
  $productsDatabase = $productsDB->fetchByCategory($category);
} else {
  $productsDB = new ProductsDB();
  $productsDatabase = $productsDB->fetch([]);
}

?>

<div class="row">
  <?php foreach ($productsDatabase as $product): ?>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100">
        <a href="#!"><img class="card-img-top" src="<?= $product['img']; ?>" alt="..." /></a>
        <div class="card-body">
          <h4 class="card-title"><a href="#!"><?= $product['name']; ?></a></h4>
          <?= ($product['price']) ?> <img class="rp-icon" src="icons/RP_icon.webp" alt="price" />
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
        </div>
        <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ☆</small></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>