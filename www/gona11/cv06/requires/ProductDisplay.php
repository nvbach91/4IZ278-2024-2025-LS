<?php require_once __DIR__ . '/../database/ProductsDB.php'?>
<?php 
    $productDB = new ProductDB();
    $products = isset($_GET['category_id'])
        ? $productDB->findByCategory($_GET['category_id'])
        : $productDB->find();
?>


<div class="row mt-3">
    <?php foreach ($products as $product): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <a href="#!"><img class="card-img-top" src=<?php echo $product['img'];?> alt="" /></a>
            <div class="card-body">
                <h4 class="card-title"><a href="#!"><?php echo $product['name'];?></a></h4>
                <h5><?php echo number_format($product['price'],2);?> CZK</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
            </div>
            <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ☆</small></div>
        </div>
    </div>  
    <?php endforeach; ?>
</div>
