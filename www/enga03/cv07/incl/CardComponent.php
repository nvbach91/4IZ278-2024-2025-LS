<?php

function renderCard($product) {
    return '
    <div class="col-md-4 mb-4">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="' . htmlspecialchars($product['img']) . '" alt="Product image">
            <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>
                <p class="card-text">' . htmlspecialchars($product['description']) . '</p>
                <p class="card-text"><strong>' . htmlspecialchars($product['price']) . ' Kč</strong></p>
                <a href="../buy.php?good_id=' . $product['good_id'] . '" class="btn btn-primary">Buy</a>
            </div>
        </div>
    </div>';
}
?>