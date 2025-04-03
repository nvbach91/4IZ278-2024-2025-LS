<?php
session_start();

if (isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];

    if (isset($_SESSION['cart'])) {
        if (($key = array_search($good_id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            // re index because of gaps
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: cart.php");
    exit();
}
?>