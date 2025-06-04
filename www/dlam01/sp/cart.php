<?php

session_start();
require_once __DIR__ . '/database/ProductsDB.php';

$products = [];
$i = 0;
if (isset($_SESSION["cart"])) {

    $ids = $_SESSION["cart"];
    $productsDB = new ProductsDB();
    foreach ($ids as $id) {
        $product = $productsDB->fetchById($id);
        if ($product) {
            $products[] = $product;
        }
    }
}
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="container">
    <h1>Shopping Cart</h1>
    <?php if (empty($products)): ?>
        <h4>Your cart is empty.</h4>
        <a class="btn btn-primary" href="./index.php">Back to Shopping</a>
    <?php else: ?>
        <h4>You have <?= count($products); ?> items in your cart.</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($products as $index => $product):
                    $totalPrice += $product['price'];
                ?>
                    <tr>
                        <td><img src="<?= $product['image']; ?>" alt="..." style="width: 50px; height: 50px;"></td>
                        <td><?= $product['name']; ?></td>
                        <td><?= $product['description']; ?></td>
                        <td><?= $product['price']; ?> $</td>
                        <td>
                            <a class="btn btn-danger" href="<?= './remove-item.php?position=' . $index; ?>">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end" style="margin-top: 20px; flex-direction: column; align-items: flex-end;">
            <h4>Total Price: <?= $totalPrice; ?> $</h4>
            <div>
            <a class="btn btn-primary" href="./index.php" style="margin-right: 10px;">Back to Shopping</a>
            <a class="btn btn-success" href="./cart-step2.php">Finish order</a>
            </div>
        </div>
        <?php endif; ?>
        <div style="margin-bottom: 30px"></div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>