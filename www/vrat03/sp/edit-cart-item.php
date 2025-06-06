<?php include __DIR__.'/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php

session_start();
$productsDB = new ProductsDB();
$isSetID = !empty($_POST['id']);
$action = isset($_POST['action']) ? $_POST['action'] : null; // 'add', 'remove', 'delete'

if ($isSetID && !empty($_SESSION["cart"])) {
    $product = $productsDB->fetchProductByID($_POST['id']);
    if ($product) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $_POST['id']) {
                if ($action === 'add') {
                    if ($product['quantity'] > 0) {
                        $_SESSION['cart'][$key]['quantity'] += 1;
                        $productsDB->updateProductQuantity($item['id'], $product['quantity'] - 1);
                    }
                } elseif ($action === 'remove') {
                    $_SESSION['cart'][$key]['quantity'] -= 1;
                    $productsDB->updateProductQuantity($item['id'], $product['quantity'] + 1);
                    if ($_SESSION['cart'][$key]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$key]);
                    }
                } elseif ($action === 'delete') {
                    $productsDB->updateProductQuantity($item['id'], $product['quantity'] + $item['quantity']);
                    unset($_SESSION['cart'][$key]);
                }
                break;
            }
        }
        header('Location: '.$urlPrefix.'/cart.php');
        exit;
    }
}
header('Location: '.$urlPrefix.'/index.php');
exit;

?>