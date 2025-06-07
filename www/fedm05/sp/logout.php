<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/UserController.php';

session_start();

$controller = new UserController();
$controller->logout();
?>
