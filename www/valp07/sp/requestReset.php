<?php
require_once 'controllers/AuthController.php';

use Controllers\AuthController;

$controller = new AuthController();
$controller->requestReset();
