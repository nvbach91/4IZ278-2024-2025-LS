<?php require_once __DIR__ . '/database/ProductsDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>
    <?php 
        session_start();
        $productsDB = new ProductsDB();
        $cartItems = $_SESSION['cart'] ?? [];
        $products = $productsDB->getItemsByIds($cartItems);
    
    ?>
    <div class="container mt-3">
        <h1 class="m-3">Your cart</h1>
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
    </div>
<?php include __DIR__ . '/includes/foot.php'?>