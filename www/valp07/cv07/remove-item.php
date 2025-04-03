<?php
session_start();

if (!isset($_GET['good_id'])) {
    header('Location: cart.php');
    exit();
}

$good_id = $_GET['good_id'];

if (isset($_SESSION['cart'])) {
    // Find the index of the item to remove
    $index = array_search($good_id, $_SESSION['cart']);
    
    // If the item was found, remove it
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);
        // Reindex the array to maintain sequential keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to cart
header('Location: cart.php');
exit();
?>