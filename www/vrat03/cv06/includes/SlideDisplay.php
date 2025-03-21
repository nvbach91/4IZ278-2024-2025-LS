<?php require_once __DIR__.'/../database/ProductsDB.php'; ?>

<?php
$productsDB = new ProductsDB();
$products = $productsDB->fetchCheapest(5); 
?>

<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
    <h2>Nejlevnější produkty:</h2>
    <ol class="carousel-indicators">
        <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php foreach ($products as $index => $product): ?>
            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                <img class="d-block img-fluid" src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" />
                <div class="card-body">
                    <h4 class="card-title"><a href="#!"><?php echo $product['name']; ?></a></h4>
                    <h5><?php echo $product['price']; ?> Kč</h5>
                </div>
            </div>
        <?php endforeach; ?>
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