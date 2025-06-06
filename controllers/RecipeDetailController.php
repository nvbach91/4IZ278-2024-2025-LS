<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Ingredient.php';


class RecipeDetailController extends BaseController
{
    public function recipe_detail()
    {
        $recipeModel = new Recipe();     
        $recipe = $recipeModel->getRecipeById($_GET['id'] ?? null);
        $ingredients = $recipeModel->getRecipeIngredients($_GET['id'] ?? null);
        $data = [
            'pageTitle' => $recipe["name"] ?? 'Recipe Not Found',
            'recipe' => $recipe,
            'ingredients' => $ingredients,
        ];
        $this->render('recipeDetail', $data);
    }
}
