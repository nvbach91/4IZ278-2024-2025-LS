<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/MyRecipesController.php';

session_start();

$controller = new MyRecipesController();
$controller->myRecipes();
?>
