<?php


$name = trim($_POST['name'] ?? '');
$price = trim($_POST['price'] ?? '');
$description = trim($_POST['description'] ?? '');
$img = trim($_POST['img'] ?? '');

if ($name === '' || $price === '' || !is_numeric($price)) {
    $error = "Name and numeric price are required.";
} else {
    $args = [
        'update' => 'name = :name, description = :description, price = :price, img = :img, lock_user_id = NULL, lock_timestamp = NULL',
        'conditions' => ['good_id = :id'],
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'img' => $img,
        'id' => $goodId
    ];

    $goodsDB->update($args);

    header("Location: home.php");
    exit;
}


?>