<?php
require_once __DIR__ . '/../database/CategoriesDB.php';

$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->fetch();
?>

<div class="col-lg-3">
    <h1 class="my-4">Rohlík shop</h1>
    <div class="list-group">
        <a href="." class="list-group-item">All categories</a>
        <?php foreach ($categories as $category): ?>
            <a href="?category_id=<?php echo $category['category_id']; ?>" class="list-group-item">
                [<?php echo $category['category_id']; ?>] <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>