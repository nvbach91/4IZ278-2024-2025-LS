<?php
require_once 'controllers/CartController.php';

use Controllers\CartController;

$controller = new CartController();
$controller->showCart();
