<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/HomeController.php';

session_start();

$controller = new HomeController();
$controller->home();
?>
