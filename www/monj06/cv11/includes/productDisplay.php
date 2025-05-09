<?php

use Illuminate\Support\Facades\Date;

require_once __DIR__ . '/../database/ProductsDB.php'; ?>
<?php
const GLOBAL_CURRENCY = '$';

// třída ProductsDB je definována v souboru ProductsDB.php
$productsDB = new ProductsDB();
// custom metoda `find` pošle SQL dotaz do databáze a vrátí všechny produkty z databáze

$numberOfItemsPerPage = 5;
$numberOfRecords = $productsDB->countRecords([])[0]['numberOfRecords'];
$numberOfPages = ceil($numberOfRecords / $numberOfItemsPerPage);
$remainingItemsOnTheLastPage = $numberOfRecords % $numberOfItemsPerPage;

$pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

$isSelectedCategory = !empty($_GET['category_id']);
if ($isSelectedCategory) {
    $category = $_GET['category_id'];
    $numberOfPages = ceil($productsDB->countRecordsCategory($category)[0]['numberOfRecordsByCategory'] / $numberOfItemsPerPage);
    $products = $productsDB->getCategoryRange($numberOfItemsPerPage, $pageNumber, $category);
} else {
    $products = $productsDB->getRange($numberOfItemsPerPage, $pageNumber);
}

var_dump($products);
echo "Today is " . date("Y-m-d h:i:s") . "<br>";
var_dump($productsDB->findById(1)[0]["edited_at"]);
?>

<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 product">
                <a href="#">
                    <img class="card-img-top product-image" src="<?php echo $product['img']; ?>" alt="mango-product-image">
                </a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#"><?php echo $product['name']; ?></a>
                    </h4>
                    <h5><?php echo number_format($product['price'], 2), ' ', GLOBAL_CURRENCY; ?></h5>
                    <p class="card-text">...</p>
                    <a href="/4IZ278/DU/du06/includes/buy.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Buy</a>
                    <?php if ($_SESSION['privilege'] > 1) : ?>
                        <a href="/4IZ278/DU/du06/includes/delete-item.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-danger">Delete</a>
                        <a href="/4IZ278/DU/du06/includes/edit-item-opt.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Edit Optimistic</a>
                        <a href="/4IZ278/DU/du06/includes/edit-item-pes.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Edit Pesimistic</a>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 0; $i < $numberOfPages; $i += 1): ?>
            <li class="page-item<?php echo $pageNumber - 1 == $i ? ' active' : ''; ?>"><a class="page-link" href="<?php echo $isSelectedCategory ?  '?category_id=' . $_GET['category_id'] .  '&page=' . $i + 1 : $_SERVER['PHP_SELF'] . '?page=' . $i + 1; ?>">
                    <?php echo $i + 1; ?>
                </a></li>
        <?php endfor; ?>
    </ul>
</nav>