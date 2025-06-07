<?php require_once __DIR__ . '/prefix.php'; ?>
<?php

$totalPrice=0;

?>

<table class="table table-hover table-striped">
    <colgroup>
        <col >
        <col>
        <col>
        <col style="width: 1%;">
    </colgroup>
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cartItems as $item){
            $DBitem = $productsDB->fetchProductByID($item['id']);
            $totalPrice += $item['price'] * $item['quantity'];
            include __DIR__.'/cart-item.php';
        }?>
    </tbody>
</table>
<div class="row justify-content-end">
    <div class="col-12 text-end">
        <h3>Total: <?php echo $totalPrice; ?> Kč</h3>
        <a href="<?php echo $urlPrefix;?>/checkout.php" class="btn btn-success">
            <span class="material-symbols-outlined align-middle">shopping_cart_checkout</span>
            Checkout
        </a>
    </div>
</div>