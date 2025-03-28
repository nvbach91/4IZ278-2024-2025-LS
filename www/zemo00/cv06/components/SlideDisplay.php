

<?php

require_once __DIR__ . "/../Database/ProductsDB.php";

$productsDB = new ProductsDB();

$randomProducts = $productsDB->fetchRandomProducts();

$randomFruits = [];

foreach($randomProducts as $product){
    array_push($randomFruits, $product);
}


?>



<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
    <ol class="carousel-indicators">
        <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active"><img class="d-block img-fluid" 
            src="<?php echo $randomFruits[0]['img']; ?>" alt="<?php echo $randomFruits[0]['name']; ?>"
            style="width: 100%; height: 400px; object-fit: cover;" /></div>
        <div class="carousel-item"><img class="d-block img-fluid" 
            src="<?php echo $randomFruits[1]['img']; ?>" alt="<?php echo $randomFruits[1]['name']; ?>" 
            style="width: 100%; height: 400px; object-fit: cover;" /></div>
        <div class="carousel-item"><img class="d-block img-fluid" 
            src="<?php echo $randomFruits[2]['img']; ?>" alt="<?php echo $randomFruits[2]['name']; ?>" 
            style="width: 100%; height: 400px; object-fit: cover;" /></div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>