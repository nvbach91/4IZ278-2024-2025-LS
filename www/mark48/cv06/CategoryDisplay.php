<?php
require_once "classes/Category.php";
require_once "db/CategoryDb.php";

$categoryDb = new CategoryDb();
$categories = $categoryDb->find();


?>

<div class="col-lg-3">
    <h1 class="my-4">CV06 Shop</h1>
    <div class="list-group">
        <?php foreach ($categories as $category): ?>
            <?php require 'CategoryCard.php'; ?>
        <?php endforeach; ?>
    </div>
</div>