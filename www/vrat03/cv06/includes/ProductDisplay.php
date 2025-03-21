<?php require_once __DIR__.'/../database/ProductsDB.php'; ?>

<?php
$productsDB = new ProductsDB();
$isSelectedCategory = !empty($_GET);
$products = $isSelectedCategory ? 
    $productsDB->fetchByCategoryID($_GET['category_id']) :
    $productsDB->fetchAll([]); 
?>


<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="#!" class="card-img"><img class="card-img-top" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                <div class="card-body">
                    <h4 class="card-title"><a href="#!"><?php echo $product['name']; ?></a></h4>
                    <h5><?php echo $product['price']; ?> Kč</h5>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>