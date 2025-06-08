<?php require_once __DIR__ . '/prefix.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php 
// Redirect to homepage if no product ID is provided
if(empty($_GET['id'])) {
    header('Location: '.$urlPrefix.'/index.php');
    exit();
}

$productsDB = new ProductsDB();
$productID = $_GET['id'];

// Fetch product details by ID
$product = $productsDB->fetchProductByID($productID);

// Redirect if product does not exist
if(empty($product)) {
    header('Location: '.$urlPrefix.'/index.php');
    exit();
}

// Fetch categories for the current product
$categories = $productsDB->fetchCategoriesByProductID($product['product_id']);

// Get category IDs for related products
$categoryIDs = array_map(function($category) {
    return $category['category_id'];
}, $categories);

// Fetch related products from the same categories, excluding the current product
$products = $productsDB->fetchProductsByCategoryIDs($categoryIDs, 4, $productID);
if(empty($products)) {
    $products = [];
}
?>

<?php require __DIR__.'/includes/head.php';?>
<div class="container mt-4">
    <div class="row align-items-center justify-content-center">
        <!-- Product image -->
        <div class="col-lg-5 mb-4">
            <img class="product-img" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" />
        </div>

        <div class="col-lg-5">
            <!-- Product name and price -->
            <h4 class="mb-2"><?php echo $product['name']; ?></h4>
            <h5><?php echo $product['price']; ?> Kč</h5>
            
            <!-- Stock status -->
            <?php if($product['quantity']<5){
                if($product['quantity']<=0){ ?>
                    <h6 class="text-danger">Out of stock</h6>
                <?php } else { ?>
                    <h6 class="text-warning">Only <?php echo $product['quantity']?> pieces left!</h6>
            <?php }} ?>
            
            
            <div class="d-flex gap-2">
                <!-- Buy button for  -->
                <form method="POST" action="<?php echo $urlPrefix ?>/add-to-cart.php" class="m-0">
                    <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                    <button class="btn btn-primary <?php echo $product['quantity'] <= 0 ? 'disabled' : ''; ?>" type="submit">Buy</button>
                </form>
                <!-- Edit button for logged-in users with privilege >= 2-->
                <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=2){ ?>
                    <a href="<?php echo $urlPrefix ?>/admin/edit-item.php?id=<?= urlencode($product['product_id']) ?>" class="btn btn-secondary">Edit</a>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Product description and details -->
            <p><?php echo nl2br(html_entity_decode($product['description'])); ?></p>
            <h6>Playtime: <?php echo $product['playtime']; ?> min</h6>
            <h6>Players: <?php echo $product['minplayers']; ?> - <?php echo $product['maxplayers']; ?></h6>

            <!-- Categories with links-->
            <h6>Category: 
                <?php foreach($categories as $category){ ?>
                    <a href="<?php echo $urlPrefix ?>/index.php?category[]=<?php echo $category['category_id']; ?>" class="badge bg-secondary">
                        <?php echo $category['name']; ?>
                    </a>
                <?php } ?>
            </h6>
        </div>

        <!-- Related products section -->
        <div class="row mt-4">
            <h4>You may also like:</h4>
            <?php include __DIR__.'/products-list.php'; ?>
        </div>
    </div>
</div>
<?php require __DIR__.'/includes/foot.php';?>