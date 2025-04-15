<?php require_once __DIR__ . '/database/ProductsDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>
    <?php 
        $loggedIn = false;
        if (isset($_COOKIE['loginSuccess'])) {
            $loggedIn = true;
        }
        $productsDB = new ProductsDB();
        $cartItems = $_SESSION['cart'] ?? [];
        $products = $productsDB->getItemsByIds($cartItems);
    
    ?>
    <div class="container mt-3">
        <?php if($loggedIn) : ?>
            <h1 class="m-3">Your cart</h1>
                <?php if(empty($cartItems)):?>
                    <h4 class="col-lg-4 ml-1 mt-3">Your cart is empty.</h4>
                <?php else: ?>
                    <h4 class="col-lg-4 ml-1 mt-3 mb-3">You have <?php echo count($cartItems)?> item/s in your cart.</h4>
                <?php endif;?>
                <div class="row">
                    <?php foreach($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="#!"><img class="card-img-top" src="<?php echo $product['img'];?>" alt="Image of product not avalible" /></a>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $product['name']; ?></h4>
                                    <h5><?php echo $product['price'];?> Czk</h5>
                                    <a href="./remove-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn buy_button btn-danger">Remove</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
        <?php else: ?>
            <div class="mt-3 flex">
            <h3>Page "Cart" is avalible only for logged in users</h3>
            <div class="row ml-2 mt-4">
                <a href="login.php" class="btn btn-primary mr-3 pl-4 pr-4">Log in</a>
                <a href="register.php" class="btn btn-secondary pl-4 pr-4">Register</a>
            </div>
        <?php endif; ?>
        </div>
    </div>
<?php include __DIR__ . '/includes/foot.php'?>