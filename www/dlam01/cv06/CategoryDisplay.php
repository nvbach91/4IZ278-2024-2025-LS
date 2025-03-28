<?php require_once __DIR__ . '/database/CategoriesDB.php'; ?>
<?php

$categoriesDB = new CategoriesDB();
$categoriesDatabase = $categoriesDB->fetch([]);

?>
 <a class="list-group-item" href=".">All Categories</a>
<?php foreach ($categoriesDatabase as $category): ?>
   <a class="list-group-item" href=<?= "?category_id=" . $category["category_id"] ?>><?= "[" . $category["category_id"] . "] " .  $category["name"] ?></a>
<?php endforeach; ?>