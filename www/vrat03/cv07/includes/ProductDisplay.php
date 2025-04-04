<?php require_once __DIR__.'/../database/ProductsDB.php'; ?>

<?php

?>

<div class="row">
    <?php foreach ($productsWithPageOffset as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="#!" class="card-img"><img class="card-img-top" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                <div class="card-body">
                    <h4 class="card-title"><a href="#!"><?php echo $product['name']; ?></a></h4>
                    <h5><?php echo $product['price']; ?> Kč</h5>
                    <a class="btn btn-primary" href="/buy.php?id=<?php echo $product['product_id']; ?>" class="button">Buy</a>
                    <a class="btn btn-primary" href="/edit-item.php?id=<?php echo $product['product_id']; ?>" class="button">Edit</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for($i=0; $i<$numberOfPages; $i++): ?>
            <li class="page-item<?php echo $pageNumber-1 == $i ? ' active' : ''; ?>"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($i + 1); ?>">
                <?php echo $i+1; ?>
            </a></li>
        <?php endfor; ?>
    </ul>
</nav>