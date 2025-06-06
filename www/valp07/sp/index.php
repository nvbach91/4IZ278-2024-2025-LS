<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/HomeController.php';

use Controllers\HomeController;

$controller = new HomeController();
$controller->index();
