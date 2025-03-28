
<?php

require __DIR__ . "/../Database/CategoriesDB.php";

$categoriesDB = new CategoriesDB();

$categories = $categoriesDB->fetchAll();


?>



<div class="col-lg-3">
    <h1 class="my-4">Fruit shop</h1>
    <div class="list-group">
        <a class="list-group-item" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">All products</a>
        <?php foreach($categories as $category):?>
            <a class="list-group-item" 
                href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category_id=<?php echo $category['category_id'];?>"> 
                <?php echo $category['name']; ?> </a>
        <?php endforeach;?>
    </div>
</div>