<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../database/ProductsDB.php';
require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../database/OrderDB.php';
require_once __DIR__ . '/../database/UserDB.php';
require_once __DIR__ . '/messages.php';
require_once __DIR__ . '/validators.php';

$productsDB = new ProductsDB();
$userDB = new UserDB();
$orderDB = new OrderDB();



?>