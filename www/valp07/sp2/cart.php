
<?php
require 'requireUser.php';
require 'db/UsersDB.php';
require 'db/PhonesDB.php';
require 'db/CartItemsDB.php';

?>

<?php require 'incl/header.php'; ?>
<?php
$productsDB = new ProductsDB();
$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
$phonesDB = new PhonesDB($connection);
$cartsDB = new CartItemsDB($connection);
$userId = $_SESSION['id'];
$cartItemIds = $cartsDB->findCartItemsByUserID($userId);
$productIds = array_column($cartItemIds, 'product_id');
$cartItems = $productsDB->findProductsByIDs($productIds);
?>
<div class="container my-4">
  <div class="row">

    <div class="col-md-6">
      <div class="row g-3">

        <?php foreach ($cartItems as $cartItem): ?>
        <div class="col-md-4">
          <div class="border p-2 text-center">
            <img src="<?php echo $cartItem['image'] ?>" class="img-fluid" alt="<?php echo $cartItem['name']; ?>">
            <h5 class="mt-2"><?php echo $cartItem['name']; ?></h5>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>

    <div class="col-md-6">
      <div class="d-grid gap-3">
        <div class="border p-3 text-center">transport checkboxes</div>
        <div class="border p-3 text-center">payment checkboxes</div>
        <div class="border p-3 text-center">address input</div>
        <div class="border p-3 text-center">Final price calculation</div>
        <button class="btn btn-primary">create order</button>
      </div>
    </div>

  </div>
</div>
<?php require 'incl/footer.php'; ?>
