<?php
require_once __DIR__ . '/controllers/ProductController.php';

use Controllers\ProductController;

$controller = new ProductController();
$controller->show();