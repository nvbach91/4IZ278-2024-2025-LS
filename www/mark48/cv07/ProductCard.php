<?php

if (!isset($product)) {
    throw new Exception('No product provided.');
}

?>
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
        <a href="buy.php?id=<?= urlencode($product->good_id) ?>">
            <img class="card-img-top" src="<?= htmlspecialchars($product->img) ?>" alt="<?= htmlspecialchars($product->name) ?>" />
        </a>
        <div class="card-body">
            <h4 class="card-title">
                <a href="buy.php?id=<?= urlencode($product->good_id) ?>">
                    <?= htmlspecialchars($product->name) ?>
                </a>
            </h4>
            <h5><?= htmlspecialchars($product->price) ?></h5>
            <p class="card-text"><?= htmlspecialchars($product->description) ?></p>
        </div>
    </div>
</div>