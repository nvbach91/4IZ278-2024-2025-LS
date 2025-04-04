<?php require_once __DIR__ . '/../database/CategoriesDB.php'; ?>

<?php
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->find();
?>

<div class="category-menu">
  <a href="." class="list-group-item list-group-item-action active">
    All categories
  </a>
  
  <?php foreach($categories as $category): ?>
    <a href="?category_id=<?php echo htmlspecialchars($category['category_id']); ?>" 
       class="list-group-item list-group-item-action">
      <?php echo htmlspecialchars($category['name']); ?>
    </a>
  <?php endforeach; ?>
</div>
