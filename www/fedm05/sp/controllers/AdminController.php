<?php
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private $recipeModel;
    private $userModel;

    public function __construct()
    {
        $this->recipeModel = new Recipe();
        $this->userModel = new User();
        
        // redirect if not admin
        if (!$this->isAdminLoggedIn()) {
            header('Location: ./login');
            exit();
        }
    }

    private function isAdminLoggedIn()
    {
        return isset($_SESSION['logged_in']) && 
               $_SESSION['logged_in'] && 
               isset($_SESSION['role']) && 
               $_SESSION['role'] === 'admin';
    }

    public function recipeManagement()
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        
        // apply filter
        if (!empty($searchTerm)) {
            $recipes = $this->recipeModel->getRecipesByFilters(['search' => $searchTerm]);
        } else {
            $recipes = $this->recipeModel->getAllRecipes();
        }

        return $recipes;
    }    public function deleteRecipe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id'])) {
            $recipeId = $_POST['recipe_id'];
            
            // soft delete the recipe - set attr to 1
            $result = $this->recipeModel->softDeleteRecipe($recipeId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Recipe deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete recipe.';
            }        }        
        return;
    }
}