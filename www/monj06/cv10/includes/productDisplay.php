<?php require_once __DIR__ . '/../database/ProductsDB.php'; ?>
<?php
const GLOBAL_CURRENCY = '$';
// vyzkousime zobrazeni komponenty pomoci statickych dat v kodu (mock)
$products = [
    ['product_id' => 1, 'name' => 'Tommy Atkins', 'price' => '49.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/1983948a-b927-4235-b0bf-adb9a11abcbd'],
    ['product_id' => 2, 'name' => 'Ataulfo',      'price' => '60.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/4e4253a0-ff3d-4730-b861-f3fbd328e463'],
    ['product_id' => 3, 'name' => 'Kent',         'price' => '47.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/1440b402-110c-4442-9272-3cdd9b178b71'],
    ['product_id' => 4, 'name' => 'Haden',        'price' => '51.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/7da75bd6-592b-4c81-be72-7297e006ea43'],
    ['product_id' => 5, 'name' => 'Keitt',        'price' => '39.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/2c27b5ac-7d03-4fcd-ae0a-e58b4c239cfb'],
    ['product_id' => 6, 'name' => 'Francine',     'price' => '59.90', 'img' => 'https://github.com/nvbach91/nvbach91/assets/20724910/9bcba5fc-ecf1-4e9e-9dda-d3f340df30f4'],
];

// pote tato data vlozime do databaze a ziskame je zpatky do aplikace pomoci dotazovani do databaze

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
                        <a href="/4IZ278/DU/du06/includes/edit-item.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Edit</a>
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