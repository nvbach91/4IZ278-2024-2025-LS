<?php
require_once __DIR__ . '/checkLock.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$controller = new \Controllers\AdminController();
$controller->showProduct();
