<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Category.php';

class RecipesController extends BaseController
{
    private $pageKey = 'recipes_page_filters';
    private $viewName = 'recipes';
    public function recipes()
    {
        $recipeModel = new Recipe();
        $categoryModel = new Category();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET["action"])) {
            $this->processAction();
        }

        // Handle search query
        if (!empty($_GET['search'])) {
            if (!isset($_SESSION[$this->pageKey])) {
                $_SESSION[$this->pageKey] = [];
            }
            $_SESSION[$this->pageKey]['search'] = $_GET['search'];
        }

        // pagination setup
        $recipesPerPage = 12;
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $recipesPerPage;

        // echo '<pre>' . print_r($_SESSION["recipes_page_filters"], true) . '</pre>';
        $filters = $_SESSION[$this->pageKey] ?? [];

        $filters['limit'] = $recipesPerPage;
        $filters['offset'] = $offset;
        $searchTerm = $filters['search'] ?? '';

        $countFilters = $_SESSION[$this->pageKey] ?? [];
        if (empty($countFilters)) {
            $allRecipes = $recipeModel->getAllRecipes();
            $totalRecipes = $allRecipes ? count($allRecipes) : 0;
        } else {
            $filteredRecipes = $recipeModel->getRecipesByFilters($countFilters);
            $totalRecipes = $filteredRecipes ? count($filteredRecipes) : 0;
        }

        if (empty($_SESSION[$this->pageKey] ?? [])) {
            $recipes = $recipeModel->getAllRecipes($recipesPerPage, $offset);
        } else {
            $recipes = $recipeModel->getRecipesByFilters($filters);
        }
        if (!$recipes) {
            $recipes = [];
        }

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

        $categories = $categoryModel->getAllCategories();
        if (!$categories) {
            $categories = [];
        }
        unset($_SESSION[$this->pageKey]['search']);
        $categoryTypes = !empty($categories) ? array_unique(array_column($categories, 'type')) : [];
        $difficultyTypesResult = $recipeModel->getUniqueDifficultyTypes();
        $difficultyTypes = !empty($difficultyTypesResult) ? array_column($difficultyTypesResult, 'difficulty') : [];
        $cookTimeFilters = [
            ['label' => 'Under 30 min', 'max' => 30],
            ['label' => '30-60 min', 'min' => 30, 'max' => 60],
            ['label' => 'Over 60 min', 'min' => 60]
        ];
        $data = [
            'pageTitle' => 'Recipes',
            'recipes' => $recipes,
            'categories' => $categories,
            'categoryTypes' => $categoryTypes,
            'difficultyTypes' => $difficultyTypes,
            'cookTimeFilters' => $cookTimeFilters,
            'activeFilters' => $_SESSION[$this->pageKey] ?? [],
            'pagination' => $pagination,
            'pageKey' => $this->pageKey,
            'searchTerm' => $searchTerm
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
                    echo "Unknown action: " . htmlspecialchars($_GET['action']);
            }
        }
    }
}
