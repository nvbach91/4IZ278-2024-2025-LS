<?php require_once __DIR__ . '/../database/SlidesDB.php'; ?>

<?php 
$slidesDB = new SlidesDB();
$slides = $slidesDB->find();
?>

<?php if (!empty($slides)): ?>
<div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">

  <!-- Indikátory -->
  <ol class="carousel-indicators">
    <?php foreach ($slides as $index => $slide): ?>
      <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
    <?php endforeach; ?>
  </ol>

  <!-- Snímky -->
  <div class="carousel-inner" role="listbox">
    <?php foreach ($slides as $index => $slide): ?>
      <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
        <img class="d-block img-fluid slide-image"
             src="<?php echo htmlspecialchars($slide['img']); ?>"
             alt="<?php echo htmlspecialchars($slide['title']); ?>">
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Ovládání -->
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>
<?php endif; ?>

