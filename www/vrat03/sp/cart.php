<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php
$productsDB = new ProductsDB();
$isCartSet = !empty($_SESSION['cart']);
if ($isCartSet) {
    $cartItems = $_SESSION['cart'];
}

?>

<?php require __DIR__.'/includes/head.php';?>

<div class="container">
    <?php if($isCartSet): ?>
        <h1 class="my-4">Cart</h1>
        <?php include __DIR__.'/cart-items.php'; ?>
    <?php else: ?>
        <h1 class="my-4">Cart is empty</h1>
    <?php endif; ?>
</div>

<?php require __DIR__.'/includes/foot.php';?>