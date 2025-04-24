<?php require_once __DIR__ . '/../database/CategoryDB.php'; 
$catDB = new CategoryDB();
$cats = $catDB->getCategories();
?>

<div class="list-group">
<?php foreach($cats as $cat): ?>
    <a class="list-group-item" href="?category_id=<?php echo $cat['category_id'];?>"> <?php echo $cat['name']; ?> </a>
    <?php endforeach; ?>
</div>