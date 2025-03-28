<?php
require_once __DIR__ . '/../db/CategoryDB.php';

$categoriesDB = new CategoryDB();
$categories = $categoriesDB->find();
?>

<div class="list-group">
    <a href="." class="list-group-item">All categories</a>
    <?php foreach ($categories as $category): ?>
        <a href="?category_id=<?php echo $category['id']; ?>" class="list-group-item">
            <?php echo $category['name']; ?>
        </a>
    <?php endforeach; ?>
</div>