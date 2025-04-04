<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php

session_start();
$productsDB = new ProductsDB();
$isSetID = !empty($_GET['id']);

if ($isSetID && !empty($_SESSION["cart"])) {
    $product = $productsDB->fetchProductByID($_GET['id']);
    if ($product) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        header('Location: cart.php');
        exit;
    }
}
header("Location: index.php");
exit;

?>