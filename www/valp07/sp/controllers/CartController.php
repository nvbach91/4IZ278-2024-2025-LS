<?php

namespace Controllers;

require_once __DIR__ . '/../requireUser.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/UsersDB.php';
require_once __DIR__ . '/../db/ProductsDB.php';
require_once __DIR__ . '/../db/PhonesDB.php';
require_once __DIR__ . '/../db/CartItemsDB.php';

use UsersDB;
use ProductsDB;
use PhonesDB;
use CartItemsDB;
use DatabaseConnection;

class CartController
{
    public function showCart()
    {

        $connection = DatabaseConnection::getPDOConnection();
        $usersDB = new UsersDB($connection);
        $productsDB = new ProductsDB($connection);
        $phonesDB = new PhonesDB($connection);
        $cartsDB = new CartItemsDB($connection);

        $userId = $_SESSION['id'];
        $cartItemIds = $cartsDB->findCartItemsByUserID($userId);
        $productIds = array_column($cartItemIds, 'product_id');
        $cartItems = $productsDB->findProductsByIDs($productIds);

        foreach ($cartItems as &$item) {
            foreach ($cartItemIds as $ci) {
                if ($ci['product_id'] == $item['id']) {
                    $item['quantity'] = $ci['quantity'];
                }
            }
        }

        require __DIR__ . '/../views/cart.view.php';
    }
}
