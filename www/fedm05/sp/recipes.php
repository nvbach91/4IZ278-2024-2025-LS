<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/RecipesController.php';

session_start();

$controller = new RecipesController();
$controller->recipes();
?>
