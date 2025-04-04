<?php
    session_start(); 
    if (isset($_GET['good_id'])) {
        $good_id = (int) $_GET['good_id'];
        if (isset($_SESSION['cart']) && in_array($good_id, $_SESSION['cart'])) {
            $key = array_search($good_id, $_SESSION['cart']);
            if ($key !== false) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }


    header('Location: cart.php');
    exit();
?>