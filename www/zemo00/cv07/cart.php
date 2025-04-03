<?php

require __DIR__ . "/incl/head.php";

session_start();
require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();

$cart = $_SESSION['cart'] ?? [];

$isCartEmpty = true;

if(!empty($cart)){

$isCartEmpty = false;

$ids = array_map(function($item){
    return (int)$item['good_id'];
}, $cart);

$ids = array_unique($ids);

$placeholders = implode(', ', $ids);

$args = [
    'columns' => ["*"],
    'conditions' => ["good_id IN ($placeholders)"]
];

$goods = $goodsDB->fetch($args);
}


?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <?php if(!$isCartEmpty):?>
            <h2>Your Cart</h2>
            <div class="row">
                <?php foreach($goods as $good): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?php echo $good['img']; ?>"/>
                        <div class="card-body">
                           <h4 class="card-title"><?php echo $good['name']; ?></h4>
                            <h5><?php echo $good['price']; ?> Kč</h5>
                            <p class="card-text"><?php echo $good['description']; ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="remove-item.php?good_id=<?php echo $good['good_id']; ?>" class="button">Remove</a>
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                   </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p class="error-message">Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

include __DIR__ . "/incl/foot.html";

?>