<?php
session_start();

if (isset($_GET['good_id'])) {
    $productId = $_GET['good_id'];

    if (!empty($_SESSION['boughtProducts'])) {
        foreach ($_SESSION['boughtProducts'] as $index => $product) {
            if ($product['product_id'] == $productId) {
                unset($_SESSION['boughtProducts'][$index]);
                $_SESSION['boughtProducts'] = array_values($_SESSION['boughtProducts']);
                break;
            }
        }
    }
}

header('Location: /4IZ278/DU/du06/includes/cart.php');
exit();
