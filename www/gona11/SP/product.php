<?php require_once __DIR__ . '/database/DB_Scripts/ProductDB.php'?>
<?php require_once __DIR__ . '/database/DB_Scripts/CategoryDB.php'?>

<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/requires/navbar.php'; ?>



<?php
$productDB = new ProductDB();
$categoryDB = new CategoryDB();

$product = $productDB->getProductById($_GET['id']);

if (!$product) {
    $_SESSION["openProductFail"] = "Produkt nemohl být zobrazen. Prosím, zkontrolujte odkaz.";
    header("Location: index.php");
    exit();
}

if(isset($_SESSION["addToCartSuccess"])) {
    $addToCartSuccess = $_SESSION["addToCartSuccess"];
    unset($_SESSION["addToCartSuccess"]);
}

if(isset($_SESSION["addToCartFailed"])) {
    $addToCartFailed = $_SESSION["addToCartFailed"];
    unset($_SESSION["addToCartFailed"]);
}

?>



<div class="container my-5">
    <?php if(isset($addToCartSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($addToCartSuccess);?></div>
    <?php endif; ?>

    <?php if(isset($addToCartFailed)) :?>
        <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($addToCartFailed);?></div>
    <?php endif; ?>
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="mb-4"><?php echo htmlspecialchars($product["name"]); ?></h1>
            <h2><?php echo htmlspecialchars($product["price"]); ?> Kč</h2>
            <p class="product-info"><b><?php echo htmlspecialchars($product["weight"]); ?> gramů</b></p>
            <p class="product-info"><b>Skladem: </b><?php echo htmlspecialchars($product["stock"]); ?> kus/ů</p>
            <a class="btn btn-primary mb-2" href="./scripts/toCart.php?id_product=<?php echo $product["id_product"];?>">Přidat do košíku</a>
            <?php if($loggedIn && $privilege > 1): ?>
                <a class="btn btn-secondary mb-2" href="./edit-product.php?id=<?php echo htmlspecialchars($product["id_product"]);?>">Upravit</a>
            <?php endif; ?>
            <div class="mt-4">
                <h3>O produktu</h3>
                <p class="product-info"><?php echo htmlspecialchars($product["description"]); ?></p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="<?php echo htmlspecialchars($product["name"]); ?>" class="img-fluid" style="max-height: 400px; width: auto;">
        </div>
    </div>
</div>


<!--
 stará verze, bez úprav pro stylizaci, ponechána kvůli testování
<div class="container mb-5">
    <?php if(isset($addToCartSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($addToCartSuccess);?></div>
    <?php endif; ?>

    <?php if(isset($addToCartFailed)) :?>
        <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($addToCartFailed);?></div>
    <?php endif; ?>

    <h1 class="text-center mt-3 mb-5"><?php echo $product["name"]; ?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="<?php echo htmlspecialchars($product["name"]); ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product["price"]); ?> Kč</h2>
            <p><?php echo htmlspecialchars($product["weight"]); ?> gramů</p>
            <p>Skladem: <?php echo htmlspecialchars($product["stock"]); ?> kus/ů</p>
            <a class="btn btn-primary" href="./scripts/toCart.php?id_product=<?php echo $product["id_product"];?>">Přidat do košíku</a>
            <?php if($loggedIn && $privilege > 1): ?>
                <a class="btn btn-secondary" href="./edit-product.php?id=<?php echo htmlspecialchars($product["id_product"]);?>">Upravit</a>
            <?php endif; ?>
        </div>
        <div class="col-md-12 mt-4">
            <h3>O produktu</h3>
            <p><?php echo htmlspecialchars($product["description"]); ?></p>
        </div>
    </div>
</div> */
<?php require __DIR__ . '/includes/foot.php'; ?>