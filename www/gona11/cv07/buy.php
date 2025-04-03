
<?php require_once __DIR__ . '/database/ProductsDB.php'?>
<?php
    session_start();
    $productsDB = new ProductsDB();
    $goodId = (int) $_GET['good_id'];
    $product = $productsDB->getItemById($goodId);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $goodId;
    header('Location: cart.php');
    exit();
?>