<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Favorite.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Category.php';


class FavouritesController extends BaseController
{
    private $pageKey = 'favourites_page_filters';
    private $viewName = 'favourites';

    public function favourites()
    {
        $categoryModel = new Category();
        $recipeModel = new Recipe();
        $categoryModel = new Category();
        $favoriteModel = new Favorite();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET["action"])) {
            $this->processAction();
        }
        $user_id = null;
        if (isset($_SESSION['user_id']) && $_SESSION["logged_in"]) {
            $user_id = $_SESSION['user_id'];
        }
        // Pagination setup
        $recipesPerPage = 12; // Number of recipes per page
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $recipesPerPage;

        // echo '<pre>' . print_r($_SESSION["recipes_page_filters"], true) . '</pre>';
        $filters = $_SESSION[$this->pageKey] ?? [];

        // add pagination to filters 
        $filters['limit'] = $recipesPerPage;
        $filters['offset'] = $offset;        // Get total count for pagination (without limit/offset)
        $countFilters = $_SESSION[$this->pageKey] ?? [];
        if (empty($countFilters)) {
            $allRecipes = $favoriteModel->getUserFavoriteRecipes($user_id);
            // echo '<pre>' . print_r($allRecipes, true) . '</pre>';
            $totalRecipes = $allRecipes ? count($allRecipes) : 0;
        } else {
            $filteredRecipes = $favoriteModel->getUserFavoriteRecipesByFilters($user_id, $countFilters);
            $totalRecipes = $filteredRecipes ? count($filteredRecipes) : 0;
        }

        // get filtered recipes with pagination
        if (empty($_SESSION[$this->pageKey])) {
            // if no filters, get all
            $recipes = $favoriteModel->getUserFavoriteRecipes($user_id, $recipesPerPage, $offset) ?? [];
        } else {
            $recipes = $favoriteModel->getUserFavoriteRecipesByFilters($user_id, $filters) ?? [];
        }

        $recipes = $this->addFavoriteStatusToRecipes($recipes);
        
        $totalPages = ceil($totalRecipes / $recipesPerPage);

        $pageUrls = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageUrls[$i] = $this->generatePaginationUrl($i);
        }


        $categories = $categoryModel->getAllCategories();
        if (!$categories) {
            $categories = [];
        }
        unset($_SESSION[$this->pageKey]['search']);
        // For rendering
        $categoryTypes = !empty($categories) ? array_unique(array_column($categories, 'type')) : [];
        $difficultyTypesResult = $recipeModel->getUniqueDifficultyTypes();
        $difficultyTypes = !empty($difficultyTypesResult) ? array_column($difficultyTypesResult, 'difficulty') : [];
        $cookTimeFilters = [
            ['label' => 'Under 30 min', 'max' => 30],
            ['label' => '30-60 min', 'min' => 30, 'max' => 60],
            ['label' => 'Over 60 min', 'min' => 60]
        ];
        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRecipes' => $totalRecipes,
            'recipesPerPage' => $recipesPerPage,
            'pageUrls' => $pageUrls
        ];

        $data = [
            'pageTitle' => 'My Favourites',
            'recipes' => $recipes,
            'categories' => $categories,
            'categoryTypes' => $categoryTypes,
            'difficultyTypes' => $difficultyTypes,
            'cookTimeFilters' => $cookTimeFilters,
            'activeFilters' => $_SESSION[$this->pageKey] ?? [],
            'pagination' => $pagination,
            'pageKey' => $this->pageKey,
        ];

        $this->render("recipes", $data);
    }

    public function addFilter()
    {
        if (isset($_GET['filter_type']) && isset($_GET['filter_value'])) {
            $filterType = $_GET['filter_type'];
            $filterValue = $_GET['filter_value'];
            if (!isset($_SESSION[$this->pageKey])) {
                $_SESSION[$this->pageKey] = [];
            }

            if (!isset($_SESSION[$this->pageKey][$filterType])) {
                $_SESSION[$this->pageKey][$filterType] = [];
            }
            if (!in_array($filterValue, $_SESSION[$this->pageKey][$filterType])) {
                $_SESSION[$this->pageKey][$filterType][] = $filterValue;
            }
        }
    }

    public function removeFilter()
    {
        if (isset($_GET['filter_type']) && isset($_GET['filter_value'])) {
            $filterType = $_GET['filter_type'];
            $filterValue = $_GET['filter_value'];
            if (isset($_SESSION[$this->pageKey][$filterType])) {
                $filters = &$_SESSION[$this->pageKey][$filterType];
                $filters = array_filter($filters, function ($value) use ($filterValue) {
                    return $value !== $filterValue;
                });

                if (empty($filters)) {
                    unset($_SESSION[$this->pageKey][$filterType]);
                }
            }
        }
    }
    public function clearAllFilters()
    {
        if (isset($_SESSION[$this->pageKey])) {
            unset($_SESSION[$this->pageKey]);
        }
    }

    public function clearSearch()
    {
        if (isset($_SESSION[$this->pageKey]['search'])) {
            unset($_SESSION[$this->pageKey]['search']);
        }
    }

    private function generatePaginationUrl($page)
    {
        $params = [];
        if ($page > 1) {
            $params['page'] = $page;
        }

        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->viewName . $queryString;
    }
    public function processAction()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add_filter':
                    $this->addFilter();
                    break;
                case 'remove_filter':
                    $this->removeFilter();
                    break;
                case 'clear_filters':
                    $this->clearAllFilters();
                    break;
                default:
                    echo "unknown action: " . htmlspecialchars($_GET['action']);
            }
        }
    }
    public function toggle()
    {
        // if not logged in return 400
        if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
            http_response_code(400);
            exit();
        }

        $recipeId = $_POST['recipe_id'] ?? null;
        $action = $_POST['action'] ?? null;
        if (!$recipeId) {
            return;
        }
        $favoriteModel = new Favorite();
        $userId = $_SESSION['user_id'];
        if ($action === 'remove') {
            $favoriteModel->removeFromFavorites($userId, $recipeId);
            return;
        }
        if ($action === 'add') {
            $favoriteModel->addToFavorites($userId, $recipeId);
            return;
        }
    }
}
