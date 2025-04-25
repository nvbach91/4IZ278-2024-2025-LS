<?php
require_once __DIR__ . '/../database/SlidesDB.php';

$slidesDB = new SlidesDB();
$slides = $slidesDB->find([]);
?>

<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
    <h3>Go imperial</h3>
    <ol class="carousel-indicators">
        <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 product">
                        <a href="#">
                            <img class="card-img-top product-image" src="<?php echo $slide['img'] ?>" alt="<?php echo $slide['title'] ?>">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#"><?php echo $slide['title'] ?></a>
                            </h4>
                        </div>
                    </div>
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