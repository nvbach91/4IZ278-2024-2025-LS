<?php require_once __DIR__ . '/../database/ProductDB.php'; 

$productsDB = new ProductDB();
$slides = $productsDB->getDiscounted();
?>

<div id="slider" class="carousel slide my-4" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach($slides as $index=>$slide): ?>
        <li data-target="#slider" data-slide-to="<?php echo $index; ?>" class="<?php echo $index == 0 ? 'active' : ''; ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php foreach($slides as $index=>$slide): ?>
        <div class="carousel-item slide <?php echo $index == 0 ? 'active' : ''; ?>">
            <img class="d-block img-fluid slide-image h-25" src="<?php echo $slide['img_url']; ?>">
        </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
