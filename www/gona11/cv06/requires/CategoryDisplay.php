<?php require_once __DIR__ . '/../database/CategoryDB.php' ?>
<?php 
    $categoriesDB = new CategoryDB();
    $categories = $categoriesDB->find();
?>

<div class="col-lg-3 mt-3">
    <div class="list-group">
        <?php foreach($categories as $category): ?>
            <a 
                href="?category_id=<?php echo htmlspecialchars($category['category_id']); ?>" 
                class="list-group-item list-group-item-action">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>




