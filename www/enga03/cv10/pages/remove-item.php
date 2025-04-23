<?php
session_start();

if (isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['good_id'] == $good_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // Reindex the cart array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: cart.php");
    exit();
}
?>