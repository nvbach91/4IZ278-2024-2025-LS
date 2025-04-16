<?php
include_once __DIR__ . '/../database/ProductsDB.php';

session_start();
$productsDB = new ProductsDB();

// Ověření, zda byl produkt vybrán
if (!empty($_GET['good_id'])) {
    $good = $productsDB->findById($_GET['good_id']);

    // Kontrola, zda produkt existuje v databázi
    if (!empty($good)) {
        // Pokud košík neexistuje, vytvoříme ho
        if (!isset($_SESSION['boughtProducts'])) {
            $_SESSION['boughtProducts'] = [];
        }
        //$_SESSION['boughtProducts'] = [];
        //$_SESSION['boughtProducts'][$productId] = $good[0];
        $_SESSION['boughtProducts'][$good[0]['product_id']] = $good[0];

        // Přesměrování zpět do košíku
        header('Location: /4IZ278/DU/du06/includes/cart.php');
        exit();
    } else {
        echo 'Product not found in the database.';
    }
} else {
    echo 'No product selected.';
}
