<?php
if (!isset($category)) {
    throw new Exception('No category provided.');
}
?>
<a class="list-group-item" href="?category_id=<?php echo $category->id ?>"><?php echo $category->name ?></a>