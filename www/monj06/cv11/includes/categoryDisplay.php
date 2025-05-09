<?php
require_once __DIR__ . '/../database/CategoriesDB.php';

$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->find([]);
?>

<div class="col-lg-3">
    <h1 class="my-4">Star wars shipyard</h1>
    <div class="list-group">
        <a class="list-group-item" href="?">Všechny kategorie</a>
        <?php foreach ($categories as $category) : ?>
            <a class="list-group-item" href="?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a>
        <?php endforeach; ?>
    </div>
</div>