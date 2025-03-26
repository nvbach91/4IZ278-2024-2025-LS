<?php
require __DIR__."/../db/CategoryDB.php";

$categoryDB = new CategoryDB();
$categories = $categoryDB->fetch([]);

?>
<div class="col-lg-3">
  <h1 class="my-4">Cypher market</h1>
  <div class="list-group">
      <a class="list-group-item" href="index.php">Všechny produkty</a>
    <?php foreach ($categories as $category): ?>
      <a class="list-group-item" href="index.php?categoryId=<?= $category["category_id"] ?>"><?= $category["name"] ?> </a>
    <?php endforeach; ?>
  </div>
</div>