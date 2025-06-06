<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/RecipeDetailController.php';

session_start();

$controller = new RecipeDetailController();
$controller->recipe_detail();
?>
