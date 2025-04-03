<?php
session_start();
require __DIR__ . '/database/ProductDB.php';
$productsDB = new ProductDB;
$ids = @$_SESSION['cart'];
$goods = [];
if (is_array($ids) && count($ids)) {
    $question_marks = str_repeat('?,', count($ids) - 1) . '?';
    $goods = $productsDB->fetchVar($question_marks, $ids);
    $sum = $productsDB->getTotalPrice($question_marks, $ids);
}
?>

<?php include './includes/header.php' ?>
<?php include './includes/navbar.php' ?>
<main class="container">
    <h1>My shopping cart</h1>
    Total goods selected: <?= count($goods) ?>
    <br><br>
    <a href="index.php">Get shopping!</a>
    <br><br>
    <?php if(@$goods): ?>
    <div class="products">
        <?php foreach($goods as $row): ?>
        <div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="<?php echo $row['img_url'] ?>" class="img-fluid rounded-start">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row['name'] ?></h5>
         
        <div class="card-subtitle">$<?php echo $row['price'] ?></div>
        <p class="card-text"><?php echo $row['description'] ?></p>
        <form action="./utils/removeItem.php" method="POST">
                    <input class="d-none" name="id" value="<?php echo $row['product_id'] ?>">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
      </div>
    </div>
  </div>
</div>
        <?php endforeach; ?>
        <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Total price: $<?php echo number_format((float)$sum, 2, '.', '');?></h5>
      </div>
    </div>
    </div>
    <?php else: ?>
    <h5>No goods yet</h5>
    <?php endif; ?>
</main>
<?php require './includes/footer.php'; ?>