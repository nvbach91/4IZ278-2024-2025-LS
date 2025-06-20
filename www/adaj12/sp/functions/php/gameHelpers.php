<?php
require_once __DIR__ . '/../../database-config/ProductsDB.php';

function getGameDetail()
{
    // Mapování ID kategorií
    $categoryNames = [
        1 => 'Rodinná',
        2 => 'Party',
        3 => 'Abstraktní',
        4 => 'Vlaková',
    ];

    // Kontrola ID v URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        return [null, $categoryNames, 'Neplatné ID hry.'];
    }

    $id = (int)$_GET['id'];
    $productsDB = new ProductsDB();
    $product = $productsDB->findById($id);

    if (!$product) {
        return [null, $categoryNames, 'Hra nebyla nalezena.'];
    }
    return [$product, $categoryNames, null];
}
