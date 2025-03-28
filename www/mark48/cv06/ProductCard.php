<?php

if (!isset($product)) {
    throw new Exception('No product provided.');
}

?>
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
        <a href="#!"><img class="card-img-top" src="<?php echo $product->imageUrl ?>" alt="..." /></a>
        <div class="card-body">
            <h4 class="card-title"><a href="#!"><?php echo $product->name ?></a></h4>
            <h5><?php echo $product->price ?></h5>
            <p class="card-text"><?php  ?></p>
        </div>
    </div>
</div>