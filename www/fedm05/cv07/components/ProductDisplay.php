<?php
require_once __DIR__ . '/../db/ProductsDB.php';

$productsDB = new ProductsDB();
$count = $productsDB->getProductCount();
$products_per_page = 5;

if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
} else {
    $offset = 0;
}

$products = $productsDB->getRelevantProducts($offset, $products_per_page);

?>

<div class="pagelist">
    <?php
        for ($i = 1; $i <= ceil($count / $products_per_page); $i++) { ?>
        <a class="<?php echo $offset / $products_per_page + 1 == $i ? "activepage" : "inactivepage"; ?>"
            href="./?offset=<?php echo ($i - 1) * $products_per_page; ?>">
            <?php echo $i; ?>
        </a>
    <?php } ?>
</div>

<div class="row">
    <div class="list-group">
        <a href="." class="list-group-item">All categories</a>
    </div>
    <div class="col-lg-9">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 product">
                        <a href="#">
                            <img class="card-img-top product-image" src="<?php echo $product['img']; ?>" alt="">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#"><?php echo $product['name']; ?></a>
                            </h4>
                            <h5><?php echo number_format($product['price'], 2), ' CZK'; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="buy-item.php?id=<?php echo $product['good_id']; ?>" class="btn btn-success">Buy</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>