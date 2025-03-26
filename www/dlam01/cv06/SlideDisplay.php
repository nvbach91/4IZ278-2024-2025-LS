<?php require_once __DIR__ . '/database/SlidesDB.php'; ?>
<?php

$slidesDB = new SlidesDB();
$slidesDatabase = $slidesDB->fetch([]);

?>

<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($slidesDatabase as $slide): ?>
            <li class="<?= $slide["slide_id"] == 1 ? "active" : "" ?>" data-target="#carouselExampleIndicators" data-slide-to=<?= $slide["slide_id"] - 1 ?>></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php foreach ($slidesDatabase as $slide): ?>
            <div class="carousel-item <?= $slide["slide_id"] == 1 ? "active" : "" ?>"><img class="d-block img-fluid" src=<?= $slide["img"] ?> alt=<?= $slide["title"] ?> /></div>
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