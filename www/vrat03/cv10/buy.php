<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php

session_start();
$productsDB = new ProductsDB();
$isSetID = !empty($_GET['id']);

if($isSetID) {
    $product = $productsDB->fetchProductByID($_GET['id']);
    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = [
            'id' => $product['product_id'],
            'price' => $product['price']
        ];
        header('Location: cart.php');
        exit;
        var_dump($_SESSION['cart']);
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID provided.";
}




?>