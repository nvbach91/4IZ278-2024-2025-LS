<?php
require_once 'controllers/UserController.php';

use Controllers\UserController;

$controller = new UserController();
$controller->profile();
