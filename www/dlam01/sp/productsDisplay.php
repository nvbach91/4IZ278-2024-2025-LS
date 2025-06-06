<?php require_once __DIR__ . '/database/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/database/AnimalsDB.php'; ?>
<?php require_once __DIR__ . '/database/CategoriesDB.php'; ?>
<?php

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$numberOfItemsPerPage = 6;
$productsDB = new ProductsDB();
$animalDB = new AnimalsDB();
$categoriesDB = new CategoriesDB();

$animalID = isset($_GET['animal_id']) ? (int)$_GET['animal_id'] : null;
$categoryID = isset($_GET['category']) ? (int)$_GET['category'] : null;
$categories = $categoriesDB->fetch(null);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$numberOfRecords = $productsDB->count($animalID, $categoryID);
$numberOfPages = ceil($numberOfRecords / $numberOfItemsPerPage);
$productsDatabase = $productsDB->fetchPage($numberOfItemsPerPage, $page, $animalID, $categoryID);

?>
<div style="margin-top: 20px"></div>
<div class="container">
  <div class="btn-group mb-3" role="group" aria-label="Categories">
    <a href="?" class="btn btn-outline-secondary <?= is_null($categoryID) ? 'active' : '' ?>">All</a>
    <?php foreach ($categories as $category): ?>
      <a href="?category=<?= $category['id']; ?>&animal_id=<?= $animalID; ?>" class="btn btn-outline-primary <?= $categoryID == $category['id'] ? 'active' : '' ?>">
        <?= $category['name']; ?>
      </a>
    <?php endforeach; ?>
  </div>
  <ul class="pagination justify-content-end">
    <li class="page-item">
      <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&animal_id=<?= $animalID ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>&animal_id=<?= $animalID ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?= min($numberOfPages, $page + 1) ?>&animal_id=<?= $animalID ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
  <div style="margin-bottom: 20px"></div>
  </nav>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <?php foreach ($productsDatabase as $product): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="<?= './product.php?id=' . $product["id"]; ?>"><img class="card-img-top" src="<?= $product['image']; ?>" alt="..." /></a>
              <div class="card-body">
                <h4 class="card-title"><a href="<?= './product.php?id=' . $product["id"]; ?>"><?= $product['name']; ?></a></h4>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <p class="mb-0 text-price"><?= $product['price']; ?> $</p>
                <?php if ($product['stock'] <= 0): ?>
                  <a class="btn btn-secondary disabled" href="#">Out of stock</a>
                <?php elseif (in_array($product['id'],$_SESSION["cart"],false)): ?>
                  <a class="btn btn-danger" href="<?= './remove-item.php?id=' . $product["id"]; ?>">-</a>
                  <span class="btn btn-success disabled">Item in the cart</span>
                  <a class="btn btn-primary" href="<?= './buy.php?id=' . $product["id"]; ?>">+</a>
                <?php else: ?>
                  <a class="btn btn-primary" href="<?= './buy.php?id=' . $product["id"]; ?>">Add to cart</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <ul class="pagination justify-content-end">
    <li class="page-item">
      <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?= min($numberOfPages, $page + 1) ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</div>
<div style="margin-bottom: 30px"></div>