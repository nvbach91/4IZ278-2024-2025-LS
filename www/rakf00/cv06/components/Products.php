<?php

require_once __DIR__."/../db/ProductDB.php";
$productDB = new ProductDB();
if (isset($_GET['categoryId'])) {
    $products = $productDB->getProductsByCategory($_GET['categoryId']);
}else{
    $products = $productDB->fetch([]);
}

?>

<div class="row">
  <?php foreach ($products as $product) : ?>
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
      <a href="#!"><img class="card-img-top"
                        src="<?= $product["image"] ?>"
                        alt="..."
          height="150px"/></a>
      <div class="card-body">
        <h4 class="card-title"><a href="#!"><?= $product["name"] ?></a></h4>
        <h5><?= $product["price"] ?> kč</h5>
      </div>
      <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ★</small></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
