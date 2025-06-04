<?php
require_once __DIR__ . '/controllers/AuthController.php';

use Controllers\AuthController;

$controller = new AuthController();
$controller->login();
