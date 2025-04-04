<?php require_once __DIR__ . '/../database/ProductDB.php'; ?>
<?php session_start();?>
<?php
$productsDB = new ProductDB();

$numberOfItemsPerPage = 6;
$pageNumber = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

$offset = $numberOfItemsPerPage * ($pageNumber - 1);

// Výběr produktů podle toho, zda je zvolena kategorie
if ($categoryId) {
    $numberOfProducts = $productsDB->countByCategory($categoryId);
    $products = $productsDB->findByCategoryPaginated($categoryId, $numberOfItemsPerPage, $offset);
} else {
    $numberOfProducts = $productsDB->countProducts();
    $products = $productsDB->findPaginated($numberOfItemsPerPage, $offset);
}

$numberOfPages = ceil($numberOfProducts / $numberOfItemsPerPage);
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
            <?php echo htmlspecialchars($product['description']); ?>
          </p>
          <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 1): ?>
          <a href="buy.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Buy</a>
          <?php endif; ?>
          <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 2 ): ?>
          <a href="edit-item.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-warning">Upravit</a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<nav>
  <ul class="pagination justify-content-center mt-4">
    <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
      <li class="page-item <?php echo ($i == $pageNumber) ? 'active' : ''; ?>">
        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $categoryId ? '&category_id=' . $categoryId : ''; ?>">
          <?php echo $i; ?>
        </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
