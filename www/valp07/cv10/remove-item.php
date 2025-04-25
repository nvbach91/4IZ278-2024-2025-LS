<?php
session_start();

if (!isset($_GET['good_id'])) {
    header('Location: cart.php');
    exit();
}

$good_id = $_GET['good_id'];

if (isset($_SESSION['cart'])) {
    $index = array_search($good_id, $_SESSION['cart']);
    
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header('Location: cart.php');
exit();
?>