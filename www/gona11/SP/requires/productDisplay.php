<?php require_once __DIR__ . '/../database/DB_Scripts/ProductDB.php'?>
<?php require_once __DIR__ . '/../database/DB_Scripts/CategoryDB.php'?>
<?php 
$loggedIn = false;
$privilegeLevel = 0;
if (isset($_COOKIE["loginSuccess"])) {
    $loggedIn = true;
    $privilegeLevel = $_SESSION['privilege'] ?? 1;
}

?>
<?php 
    if(isset($_SESSION["editProductSuccess"])) {
        $editProductSuccess = $_SESSION["editProductSuccess"];
        unset($_SESSION["editProductSuccess"]);
    }

    $productDB = new ProductDB();
    $categoryDB = new CategoryDB();
    $category = isset($_GET["category"]) && is_numeric($_GET["category"]) ? (int)$_GET["category"] : null;
    $categoryName = $category ? $categoryDB->getCategoryName($category) : null;
    $products = $category ? $productDB->getProductsByCategory($category) : $productDB->getAllProducts();
?>

<div class="container mb-5">


    <?php if(isset($editProductSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($editProductSuccess);?></div>
    <?php endif; ?>

    <h1 class="text-center mt-3 mb-4">
        <?php echo ($categoryName && isset($categoryName["name"])) ? htmlspecialchars($categoryName["name"]) : "Všechny produkty"; ?>
    </h1>
</div>

<div class="container">
        <div class="col-lg-12">
            <div class="row mt-4">
                <?php foreach($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <a href="product.php?id=<?php echo htmlspecialchars($product["id_product"]);?>">
                            <img class="card-img-top hover" src="<?php echo htmlspecialchars($product['image']);?>" alt="Image of product not avalible" />
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title"><?php echo htmlspecialchars($product["name"]);?></h4>
                            <div class="mt-auto d-flex justify-content-between align-items-end gap-2">
                                <div class="card-buttons">
                                    <a class="btn btn-primary btn-sm" href="./scripts/toCart.php?id_product=<?php echo htmlspecialchars($product["id_product"]);?>">Přidat do košíku</a>
                                    <?php if($loggedIn && $privilege > 1): ?>
                                        <a class="btn btn-secondary btn-sm" href="./edit-product.php?id=<?php echo htmlspecialchars($product["id_product"]);?>">Upravit</a>
                                    <?php endif; ?>
                                </div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($product["price"]);?> Kč</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
