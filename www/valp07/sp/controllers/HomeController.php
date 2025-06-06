<?php

namespace Controllers;

require_once __DIR__ . '/../db/ProductsDB.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/UsersDB.php';
require_once __DIR__ . '/../db/PhonesDB.php';

use ProductsDB;
use PhonesDB;
use DatabaseConnection;

class HomeController
{
public function index()
{
    $connection = DatabaseConnection::getPDOConnection();
    $productsDB = new ProductsDB($connection);

    $itemsPerPage = 6;
    $pageNumber = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($pageNumber - 1) * $itemsPerPage;

    $products = [];
    $totalRecords = 0;

    if (isset($_GET['search_submit']) && !empty($_GET['search'])) {
        $search = trim($_GET['search']);
        $results = $productsDB->searchProducts($search, $itemsPerPage, $offset);
        $products = $results['products'];
        $totalRecords = $results['total'];
    } elseif (isset($_GET['filter_submit'])) {
        $specs = [];
        foreach (['screen_size', 'ram', 'storage', 'battery', 'brand', 'price'] as $key) {
            if (!empty($_GET[$key])) {
                $specs[$key] = is_numeric($_GET[$key]) ? +$_GET[$key] : $_GET[$key];
            }
        }
        if (!empty($_GET['in_stock'])) {
            $specs['in_stock'] = true;
        }

        $results = $productsDB->findPhonesBySpecsWithCount($specs, $itemsPerPage, $offset);
        $products = $results['products'];
        $totalRecords = $results['total'];
    } else {
        $products = $productsDB->getAllWithPagination($itemsPerPage, $offset);
        $totalRecords = $productsDB->countRecords('products');
    }

    $totalPages = ceil($totalRecords / $itemsPerPage);

    require __DIR__ . '/../views/home.view.php';
}

}
