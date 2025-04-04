<?php require_once __DIR__ . '/database/GoodsDB.php'; ?>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$goodsDB = new GoodsDB();
$numberOfItemsPerPage = 6;
$numberOfRecords = $goodsDB->countAll();
$numberOfPages = ceil($numberOfRecords / $numberOfItemsPerPage);
$goodsDatabase = $goodsDB->fetchPage($numberOfItemsPerPage, $page);

?>
<div class="container">
  <nav aria-label="Page navigation example">
    <h1>Store page</h1>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
      <?php endfor; ?>
    </ul>
    <a class="btn btn-success" href="./create-item.php">Add new item</a>
    <div style="margin-bottom: 20px"></div>
  </nav>
  <div class="row">
    <div class="col-lg-9">
      <div class="row">
        <?php foreach ($goodsDatabase as $product): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#!"><img class="card-img-top" src="<?= $product['img']; ?>" alt="..." /></a>
              <div class="card-body">
                <h4 class="card-title"><a href="#!"><?= $product['name']; ?></a></h4>
                <?= ($product['price']) ?> $
                <p class="card-text"><?= $product["description"]; ?></p>
              </div>
              <div class="card-controls">
                <div class="card-buttons">
                <a class="btn btn-secondary card-link" href=<?= './buy.php?id=' . $product["good_id"]; ?>>Buy</a>
                <a class="btn btn-secondary card-link" href=<?= './edit.php?id=' . $product["good_id"]; ?>>Edit</a>
                <a class="btn btn-danger card-link" href=<?= './delete.php?id=' . $product["good_id"]; ?>>Delete</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>