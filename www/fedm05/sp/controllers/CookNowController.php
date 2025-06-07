<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Ingredient.php';


class CookNowController extends BaseController
{
    private $pageKey = 'cooknow_page_filters';
    private $viewName = 'cooknow';
    
    public function cooknow()
    {
        $recipeModel = new Recipe();
        $ingredientModel = new Ingredient();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_GET["action"])) {
            $this->processAction();
        }
        // Pagination setup
        $recipesPerPage = 12; // Number of recipes per page
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $recipesPerPage;
        $filters = $_SESSION[$this->pageKey] ?? [];

        // add pagination to filters
        $filters['limit'] = $recipesPerPage;
        $filters['offset'] = $offset;
        $countFilters = $_SESSION[$this->pageKey] ?? [];
        if (empty($countFilters)) {
            $allRecipes = $recipeModel->getAllRecipes();
            $totalRecipes = is_array($allRecipes) ? count($allRecipes) : 0;
        } else {
            $countResult = $recipeModel->getRecipesByAllIngredients($countFilters);
            $totalRecipes = is_array($countResult) ? count($countResult) : 0;
        }
        
        // filtered recipes with pagination
        if (empty($_SESSION[$this->pageKey] ?? [])) {
            $recipes = $recipeModel->getAllRecipes($recipesPerPage, $offset);
        } else {
            $recipes = $recipeModel->getRecipesByAllIngredients($filters);
        }        if (!$recipes) {
            $recipes = [];
        }

        // add favorite
        $recipes = $this->addFavoriteStatusToRecipes($recipes);
        


        $totalPages = ceil($totalRecipes / $recipesPerPage);
        $pageUrls = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageUrls[$i] = $this->generatePaginationUrl($i);
        }

        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRecipes' => $totalRecipes,
            'recipesPerPage' => $recipesPerPage,
            'pageUrls' => $pageUrls
        ];        
        // categories for the sidebar
        $ingredients = $ingredientModel->getAllIngredients();
        $ingredientTypes = !empty($ingredients) ? array_unique(array_column($ingredients, 'category')) : [];

        $data = [
            'pageTitle' => 'Cook Now',
            'recipes' => $recipes,
            'ingredients' => $ingredients,
            'ingredientTypes' => $ingredientTypes,
            'activeFilters' => $_SESSION[$this->pageKey] ?? [],
            'pagination' => $pagination,
            'pageKey' => $this->pageKey,
        ];

        $this->render($this->viewName, $data);
    }

    public function addFilter()
    {
        if (isset($_GET['filter_type']) && isset($_GET['filter_value'])) {
            $filterType = $_GET['filter_type'];
            $filterValue = $_GET['filter_value'];
            if (!isset($_SESSION[$this->pageKey])) {
                $_SESSION[$this->pageKey] = [];
            }

            // add filter to session
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
                    echo "Unknown action: " . htmlspecialchars($_GET['action']);
            }
        }
    }
}
