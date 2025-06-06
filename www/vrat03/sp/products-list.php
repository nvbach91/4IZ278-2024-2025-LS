<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require_once __DIR__ . '/prefix.php'; ?>

<div id="cartAlert" class="alert" role="alert" style="display: none;"></div>

<?php
foreach ($products as $product): ?>
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="card h-100">
            <a href="<?php echo $urlPrefix ?>/product.php?id=<?php echo $product['product_id']; ?>" class="card-img">
                <img class="card-img-top" src="<?php echo $product['img_thumb']; ?>" alt="<?php echo $product['name']; ?>" />
            </a>
            <div class="card-body">
                <h4 class="card-title"><a href="<?php echo $urlPrefix ?>/product.php?id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a></h4>
                <h5><?php echo $product['price']; ?> Kč</h5>
                
                <?php if($product['quantity']<5){
                    if($product['quantity']<=0){ ?>
                        <h6 class="text-danger">Out of stock</h6>
                    <?php } else { ?>
                        <h6 class="text-warning">
                            Only <?php echo $product['quantity']; ?> piece<?php echo $product['quantity'] > 1 ? 's' : ''; ?> left!
                        </h6>
                    <?php } 
                } else { ?>
                        <h6 class="text-success">In stock</h6>
                <?php } ?>
                
                <div class="d-flex gap-2">
                    <form method="POST" action="<?php echo $urlPrefix ?>/add-to-cart.php" class="addToCart">
                        <input type="hidden" name="id" value=<?php echo $product['product_id']; ?>>
                        <button class="btn btn-primary d-flex align-items-center <?php echo $product['quantity'] <= 0 ? 'disabled' : ''; ?>" type="submit">
                            <span class="material-symbols-outlined">add_shopping_cart</span>
                            Buy
                        </button>
                    </form>             
                    <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=2){ ?>
                        <a href="<?php echo $urlPrefix ?>/admin/edit-item.php?id=<?= urlencode($product['product_id']) ?>" class="btn btn-secondary">Edit</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script src="./js/add-to-cart.js"></script>