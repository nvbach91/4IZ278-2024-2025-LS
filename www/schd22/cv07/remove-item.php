<?php
session_start();

if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die('Neplatné ID pro odstranění.');
}

$goodId = (int) $_GET['product_id'];

// Košík musí existovat
if (isset($_SESSION['cart'])) {
    // Najdi pozici prvního výskytu v poli
    $key = array_search($goodId, $_SESSION['cart']);
    
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        // Přeuspořádej indexy (volitelně)
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header('Location: cart.php');
exit();
