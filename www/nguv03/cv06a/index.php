<?php require_once __DIR__ . '/database/UserDB.php' ?>
<?php require_once __DIR__ . '/database/ProductDB.php' ?>
<?php
$userDB = new UserDB();
$users = $userDB->fetch([]);

$productDB = new ProductDB();
$products = $productDB->fetch([]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php foreach($users as $user): ?>
            <li><?php echo $user['name']; ?></li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php foreach($products as $product): ?>
            <li>
                <?php echo $product['name']; ?>
                -
                <?php echo $product['price']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>