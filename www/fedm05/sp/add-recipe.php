<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/AddRecipeController.php';

session_start();

$controller = new AddRecipeController();
$controller->addrecipe();
?>
