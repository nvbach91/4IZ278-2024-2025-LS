<?php
require_once __DIR__ . '/../../database-config/ProductsDB.php';

function getProductsDB() {
    static $productsDB = null;
    if ($productsDB === null) {
        $productsDB = new ProductsDB();
    }
    return $productsDB;
}

function getCategories() {
    return getProductsDB()->fetchAllCategories();
}

function getGenres() {
    return getProductsDB()->fetchAllGenres();
}

function handleAddToCart() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
        $id = intval($_POST['product_id']);
        $qty = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            $_SESSION['cart'][$id] += $qty;
        }

        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?added=1');
        exit;
    }
}

function getFilters() {
    return [
        'category' => $_GET['category'] ?? null,
        'genre' => $_GET['genre'] ?? null,
        'min_age' => $_GET['min_age'] ?? null,
        'max_price' => $_GET['max_price'] ?? null,
    ];
}

function getProducts($filters, $limit = 10, $offset = 0) {
    return getProductsDB()->fetchFiltered($filters, $limit, $offset);
}

function getProductsCount($filters) {
    return getProductsDB()->countFiltered($filters);
}
?>
