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
    }    public function recipeManagement()
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        
        $recipesPerPage = 12;
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $recipesPerPage;
        
        $filters = [];
        if (!empty($searchTerm)) {
            $filters['search'] = $searchTerm;
        }
        
        // total count for pagination
        if (empty($filters)) {
            $allRecipes = $this->recipeModel->getAllRecipes();
            $totalRecipes = $allRecipes ? count($allRecipes) : 0;
        } else {
            $filteredRecipes = $this->recipeModel->getRecipesByFilters($filters);
            $totalRecipes = $filteredRecipes ? count($filteredRecipes) : 0;
        }
        
        // add pagination filters
        $filters['limit'] = $recipesPerPage;
        $filters['offset'] = $offset;
        
        // get paginated recipes
        if (empty($searchTerm)) {
            $recipes = $this->recipeModel->getAllRecipes($recipesPerPage, $offset);
        } else {
            $recipes = $this->recipeModel->getRecipesByFilters($filters);
        }
        
        if (!$recipes) {
            $recipes = [];
        }
        
        $totalPages = ceil($totalRecipes / $recipesPerPage);
        
        $pageUrls = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageUrls[$i] = $this->generatePaginationUrl($i, $searchTerm);
        }
        
        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRecipes' => $totalRecipes,
            'recipesPerPage' => $recipesPerPage,
            'pageUrls' => $pageUrls
        ];
        $data = [
            'pageTitle' => 'Recipe Management',
            'recipes' => $recipes,
            'pagination' => $pagination,
            'searchTerm' => $searchTerm
        ];
        return $data;
    }
    
    private function generatePaginationUrl($page, $searchTerm = '')
    {
        $params = [];
        if ($page > 1) {
            $params['page'] = $page;
        }
        if (!empty($searchTerm)) {
            $params['search'] = $searchTerm;
        }

        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        $baseName = basename($_SERVER['PHP_SELF'], '.php');
        return $baseName . $queryString;
    }public function deleteRecipe()
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