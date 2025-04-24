<?php require_once __DIR__ . '/../database/ProductDB.php'; 
require_once __DIR__ . '/../database/UserDB.php'; 


$productsDB = new ProductDB();
if (isset($_GET['category_id'])) {
  $products = $productsDB->findByCategory($_GET['category_id']);
} else {
  $products = $productDB->fetchPage($noItemsPerPage, $noItemsPerPage * ($pageNum-1));
}

$userDB = new UserDB();
$priv = 0;
if(isset($_SESSION['name'])) {
$priv = $userDB->fetchUser($_SESSION['email'])[0]['privilege'];
}
?>

  <?php foreach($products as $product): ?>
<div class="col-lg-4 col-md-6 mb-4">
  
    <div class="card h-100">
        <a href="#!"><img class="card-img-top" src="<?php echo $product['img_url'];?>" alt="..." /></a>
        <div class="card-body">
            <h4 class="card-title"><a href="#!"><?php echo $product['name']; ?></a></h4>
            <h5>$<?php echo $product['price']; ?></h5>
            <p class="card-text"><?php echo $product['description']; ?></p>
        </div>
    
        <div class="card-footer"><a class="btn btn-primary" href="./utils/buy.php?product=<?php echo $product['product_id'] ?>" role="button">Buy</a>

        <?php if($priv > 0): ?>
        <a class="btn btn-secondary card-link" href='edit.php?id=<?php echo $product['product_id'] ?>'>Edit</a>
        <a class="btn btn-danger card-link" href='./utils/delete.php?id=<?php echo $product['product_id'] ?>'>Delete</a>
        <?php endif ?>
      
      </div>
         
   
      </div>
</div>
<?php endforeach; ?>