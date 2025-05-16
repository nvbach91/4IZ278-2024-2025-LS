<?php 
if(empty($productsWithPageOffset)) {
    echo '<div">No products found.</div>';
    return;
}
foreach ($productsWithPageOffset as $product): ?>
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="card h-100">
            <a href="product.php?id=<?php echo $product['product_id']; ?>" class="card-img"><img class="card-img-top" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" /></a>
            <div class="card-body">
                <h4 class="card-title"><a href="product.php?id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a></h4>
                <h5><?php echo $product['price']; ?> Kč</h5>
                
                <?php if($product['quantity']<5){
                    if($product['quantity']<=0){ ?>
                        <h6 class="text-danger">Out of stock</h6>
                    <?php } else { ?>
                        <h6 class="text-warning">Only <?php echo $product['quantity']?> pieces left!</h6>
                <?php }} ?>
                
                <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=1){ ?>
                    <a class="btn btn-primary <?php echo $product['quantity'] <= 0 ? 'disabled' : ''; ?>" 
                        href="buy.php?id=<?php echo $product['product_id']; ?>" class="button">Buy</a>
                <?php } ?>

                <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=2){ ?>
                    <a class="btn btn-secondary" href="admin/edit-item.php?id=<?php echo $product['product_id']; ?>" class="button">Edit</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php if (!$_GET) {
                    $parameters='?page=';
                } elseif(in_array('page', $_GET)) {
                    $parametersWithoutPage=$_GET;
                    unset($parametersWithoutPage['page']);
                    $parameters='?'.http_build_query($parametersWithoutPage).'&page=';
                } else {
                    $parameters='?'.http_build_query($_GET).'&page=';
                }
            for($i=0; $i<$numberOfPages; $i++):  
        ?>
            <li class="page-item<?php echo $pageNumber-1 == $i ? ' active' : ''; ?>"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . $parameters . ($i + 1); ?>">
                <?php echo $i+1; ?>
            </a></li>
        <?php endfor; ?>
    </ul>
</nav>