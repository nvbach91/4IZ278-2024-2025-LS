<?php

namespace Controllers;

require_once __DIR__ . '/../db/ProductsDB.php';
require_once __DIR__ . '/../db/PhonesDB.php';
require_once __DIR__ . '/../db/UsersDB.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';

use ProductsDB;
use PhonesDB;
use UsersDB;
use DatabaseConnection;

class ProductController
{
    public function show()
    {
        session_start();

        $productId = $_GET['id'] ?? null;

        if (!$productId || !is_numeric($productId)) {
            http_response_code(400);
            echo "Invalid product ID.";
            exit;
        }

        $connection = DatabaseConnection::getPDOConnection();
        $productsDB = new ProductsDB($connection);
        $phonesDB = new PhonesDB($connection);

        $product = $productsDB->findProductByID($productId);
        $productDetails = $phonesDB->findPhoneByID($productId);

        if (!$product) {
            http_response_code(404);
            echo "Product not found.";
            exit;
        }

        require __DIR__ . '/../views/product.view.php';
    }
}
