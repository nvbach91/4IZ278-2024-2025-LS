<?php include __DIR__.'/prefix.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php include __DIR__.'/privileges.php'; ?>
<?php

if(!isset($_SESSION)) { 
    session_start(); 
}

$productsDB = new ProductsDB();
$isCartSet = !empty($_SESSION['cart']);
if ($isCartSet) {
    $cartItems = $_SESSION['cart'];
}

?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class="container">
    <?php if($isCartSet): ?>
        <h2>Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): $DBitem = $productsDB->fetchProductByID($item['id'])?>
                    <tr>
                        <td><?php echo htmlspecialchars($DBitem['name']) ?></td>
                        <td><?php echo htmlspecialchars($item['price'])." Kč" ?></td>
                        <td><a class="btn btn-primary" href="<?php echo $prefix;?>/remove-item.php?id=<?php echo $item['id']; ?>" class="button">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h2>Cart is empty</h2>
    <?php endif; ?>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>