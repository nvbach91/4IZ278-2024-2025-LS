<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/CookNowController.php';

session_start();

$controller = new CookNowController();
$controller->cooknow();
?>
