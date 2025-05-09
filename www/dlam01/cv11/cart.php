<?php

session_start();
if ($_SESSION['privilege'] < '1') {
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/database/GoodsDB.php';

$goods = [];
$i = 0;
if (isset($_SESSION["cart"])) {

    $ids = $_SESSION["cart"];
    $goodsDB = new GoodsDB();
    foreach ($ids as $id) {
        $good = $goodsDB->fetchById($id);
        if ($good) {
            $goods[] = $good;
        }
    }
}

?>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="container">
    <h1>Shopping Cart</h1>
    <?php if (empty($goods)): ?>
        <h4>Your cart is empty.</h4>
    <?php else: ?>
        <h4>You have <?= count($goods); ?> items in your cart.</h4>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <?php foreach ($goods as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="#!"><img class="card-img-top" src="<?= $product['img']; ?>" alt="..." /></a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="#!"><?= $product['name']; ?></a></h4>
                                <?= ($product['price']) ?> $
                                <p class="card-text"><?= $product["description"]; ?></p>
                            </div>
                            <div class="card-controls">
                                <a class="btn btn-danger card-link" href=<?= './remove-item.php?position=' . $i; ?>>Remove</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                $i++ ?>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="./index.php">Back to Shopping</a>
    <div style="margin-bottom: 20px"></div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>