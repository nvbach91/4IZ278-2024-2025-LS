<?php include __DIR__.'/../prefix.php'; ?>
<?php require_once __DIR__.'/../database/CategoriesDB.php'; ?>
<?php
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->fetchAll([]);
?>

<div class="col-lg-3">
    <h1 class="my-4">My e-shop</h1>
    <div class="list-group">
        <a class="list-group-item" href="<?php echo $prefix;?>/index.php">Všechny kategorie</a>
        <?php foreach ($categories as $category): ?>
            <a class="list-group-item" href="<?php echo $prefix;?>/index.php?category_id=<?php echo $category['category_id'];?>"><?php echo $category['name']; ?></a>
        <?php endforeach; ?>
    </div>
</div>