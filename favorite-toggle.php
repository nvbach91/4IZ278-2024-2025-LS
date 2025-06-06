<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/FavouritesController.php';

session_start();

$controller = new FavouritesController();
$controller->toggle();
?>
