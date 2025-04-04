

<?php

$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

$args = [
    'limit' => $itemsPerPage,
    'offset' => $offset
];
$goods = $goodsDB->fetchAllWithOffset($args);


?>



<?php foreach($goods as $good): ?>
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
        <img class="card-img-top" src="<?php echo $good['img']; ?>" alt="..." />
        <div class="card-body">
            <h4 class="card-title"><?php echo $good['name']; ?></h4>
            <h5><?php echo $good['price']; ?> Kč</h5>
            <p class="card-text"><?php echo $good['description']; ?></p>
        </div>
        <div class="card-footer">
            <a href="buy.php?good_id=<?php echo $good['good_id']; ?>" class="button">Buy</a>
            <a href="edit-item.php?good_id=<?php echo $good['good_id']; ?>" class="button">Edit</a>
            <a href="delete-item.php?good_id=<?php echo $good['good_id']; ?>" class="button">Delete</a>
        </div>
    </div>
</div>
<?php endforeach; ?>
