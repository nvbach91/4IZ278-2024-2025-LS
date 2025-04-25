<?php include __DIR__.'/../prefix.php'; ?>
<?php require_once __DIR__.'/../database/ProductsDB.php'; ?>

<?php

?>

<div class="row">
    <?php foreach ($productsWithPageOffset as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="<?php echo $prefix;?>#!" class="card-img"><img class="card-img-top" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                <div class="card-body">
                    <h4 class="card-title"><a href="<?php echo $prefix;?>#!"><?php echo $product['name']; ?></a></h4>
                    <h5><?php echo $product['price']; ?> Kč</h5>
                    <a class="btn btn-primary" href="<?php echo $prefix;?>/buy.php?id=<?php echo $product['product_id']; ?>" class="button">Buy</a>
                    <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=2){ ?>
                    <a class="btn btn-primary" href="<?php echo $prefix;?>/edit-item.php?id=<?php echo $product['product_id']; ?>" class="button">Edit</a>
                    <?php } ?>
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