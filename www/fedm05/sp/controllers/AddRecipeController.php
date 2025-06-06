<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Ingredient.php';


class AddRecipeController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function addrecipe()
    {
        // Check if form was submitted

        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ./login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_recipe'])) {
            $this->processform();
            return;
        }

        // display the form
        $data = [
            'pageTitle' => "Add new recipe",
        ];
        $this->render('addRecipe', $data);
    }

    // process the submitted form
    public function processform()
    {
        try {
            // validate fields
            if (
                empty($_POST['recipe_name']) || empty($_POST['portions']) ||
                empty($_POST['difficulty']) || empty($_POST['cooking_time']) ||
                empty($_POST['instructions'])
            ) {
                throw new Exception('Please fill in all required fields.');
            }

            // file upload
            $imagePath = $this->handleImageUpload();

            $recipeData = [
                'name' => trim($_POST['recipe_name']),
                'difficulty' => $_POST['difficulty'],
                'cooktime' => (int)$_POST['cooking_time'],
                'portions' => (int)$_POST['portions'],
                'img' => $imagePath,
                'owner_user_id' => $_SESSION['user_id'] ?? 1,
                'description' => trim($_POST['instructions'])
            ];

            $recipeModel = new Recipe();
            $recipeId = $recipeModel->createRecipe($recipeData);

            $this->processIngredients($recipeId);
            $this->processCategories($recipeId);

            header('Location: ./myrecipes');
            exit;
        } catch (Exception $e) {
            $data = [
                'pageTitle' => "Add new recipe",
                'error' => $e->getMessage()
            ];
            $this->render('addRecipe', $data);
        }
    }

    private function handleImageUpload()
    {
        if (!isset($_FILES['recipe_image']) || $_FILES['recipe_image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['recipe_image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error uploading image.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['recipe_image']['type'], $allowedTypes)) {
            throw new Exception('Invalid image type. Please upload JPEG, PNG, or GIF.');
        } // set the directory
        $uploadDir = __DIR__ . '/../assets/recipes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('recipe_') . '.' . $extension;
        $fullPath = $uploadDir . $filename;

        move_uploaded_file($_FILES['recipe_image']['tmp_name'], $fullPath);

        return 'assets/recipes/' . $filename;
    }

    private function processIngredients($recipeId)
    {
        if (!isset($_POST['ingredient_name']) || !is_array($_POST['ingredient_name'])) {
            return;
        }

        $ingredientNames = $_POST['ingredient_name'];
        $ingredientAmounts = $_POST['ingredient_amount'] ?? [];
        $ingredientUnits = $_POST['ingredient_unit'] ?? [];

        for ($i = 0; $i < count($ingredientNames); $i++) {
            if (empty($ingredientNames[$i])) {
                continue;
            }

            $ingredientName = trim($ingredientNames[$i]);
            $amount = isset($ingredientAmounts[$i]) ? (float)$ingredientAmounts[$i] : 0;
            $unitName = isset($ingredientUnits[$i]) ? trim($ingredientUnits[$i]) : '';

            $ingredientId = $this->findOrCreateIngredient($ingredientName);
            $unitId = $this->findOrCreateUnit($unitName);
            $this->linkIngredientToRecipe($recipeId, $ingredientId, $amount, $unitId);
        }
    }

    private function findOrCreateIngredient($name)
    {
        $query = "SELECT id FROM ingredients WHERE name = :name AND deleted = 0";
        $result = $this->db->select($query, ['name' => $name]);
        // if ingredient exists, return its ID
        if (!empty($result)) {
            return $result[0]['id'];
        }

        // otherwise create a new ingredient
        $ingredientData = [
            'name' => $name,
            'category' => 'Other',
            'deleted' => 0
        ];

        return $this->db->insert('ingredients', $ingredientData);
    }


    private function findOrCreateUnit($name)
    {
        if (empty($name)) {
            return null;
        }

        // check if unit exists
        $query = "SELECT id FROM units WHERE unit_name = :name OR unit_shortname = :name";
        $result = $this->db->select($query, ['name' => $name]);

        if (!empty($result)) {
            return $result[0]['id'];
        }

        // create new unit
        $unitData = [
            'unit_name' => $name,
            'unit_shortname' => $name
        ];

        return $this->db->insert('units', $unitData);
    }

    private function linkIngredientToRecipe($recipeId, $ingredientId, $amount, $unitId)
    {
        $data = [
            'recipe_id' => $recipeId,
            'ingredient_id' => $ingredientId,
            'amount' => $amount,
            'unit_id' => $unitId
        ];

        $this->db->insert('recipe_ingredients', $data);
    }

    private function processCategories($recipeId)
    {
        if (!isset($_POST['ingredient_name']) || !is_array($_POST['ingredient_name'])) {
            return;
        }

        $categoryTypes = $_POST['recipe_category_type'];
        $categoryNames = $_POST['recipe_category_name'] ?? [];

        for ($i = 0; $i < count($categoryTypes); $i++) {
            if (empty($categoryTypes[$i])) {
                continue;
            }

            $categoryType = $categoryTypes[$i];
            $categoryName = $categoryNames[$i];

            $categoryId = $this->findOrCreateCategory($categoryType, $categoryName);
            $this->linkCategoryToRecipe($recipeId, $categoryId);
        }
    }

    private function findOrCreateCategory($categoryType, $categoryName)
    {
        $query = "SELECT id FROM categories WHERE name = :name AND type = :type";
        $categoryName = trim($categoryName);
        $categoryType = trim($categoryType);

        $result = $this->db->select($query, ['name' => $categoryName, 'type' => $categoryType]);
        // if category exists, return its ID
        if (!empty($result)) {
            return $result[0]['id'];
        }

        // otherwise create a new ingredient
        $ingredientData = [
            'type' => $categoryType,
            'name' => $categoryName,
        ];

        return $this->db->insert('categories', $ingredientData);
    }

    private function linkCategoryToRecipe($recipeId, $categoryId)
    {
        $data = [
            'recipe_id' => $recipeId,
            'category_id' => $categoryId,
        ];

        $this->db->insert('recipe_categories', $data);
    }
}
