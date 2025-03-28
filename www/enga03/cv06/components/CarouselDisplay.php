<?php
require_once __DIR__ . '/../database/SlidesDB.php';

$slidesDB = new SlidesDB();
$slides = $slidesDB->fetch();
?>

<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($slides as $index => $slide): ?>
            <li style="background-color: black" data-target="#carouselExampleIndicators" data-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <img class="d-block w-100" src="<?php echo htmlspecialchars($slide['img']); ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>">
                <p><?php echo htmlspecialchars($slide['title']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span style="background-color: black" class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span style="background-color: black" class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span style="background-color: black" class="carousel-control-next-icon" aria-hidden="true"></span>
        <span style="background-color: black" class="sr-only">Next</span>
    </a>
</div>