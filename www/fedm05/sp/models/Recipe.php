<?php
require_once __DIR__ . '/../db/Database.php';

class Recipe
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllRecipes($limit = null, $offset = 0)
    {
        $query = "SELECT r.*, u.username as owner_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id 
                  WHERE r.deleted = 0 
                  ORDER BY r.created_at DESC";
        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
            $result = $this->db->select($query, [
                'limit' => $limit,
                'offset' => $offset
            ]);
            return is_array($result) ? $result : [];
        }

        $result = $this->db->select($query);
        return is_array($result) ? $result : [];
    }

    public function getRecipesByFilters($filters)
    {
        $query = "SELECT DISTINCT r.*, u.username as owner_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id";

        $joins = [];
        $conditions = ["r.deleted = 0"];
        $params = [];
        $paramCounter = 0;

        // Add joins if filtering by categories or ingredients
        if (!empty($filters['category'])) {
            $joins[] = "INNER JOIN recipe_categories rc ON r.id = rc.recipe_id";
            $joins[] = "INNER JOIN categories c ON rc.category_id = c.id";
        }

        if (!empty($filters['ingredient'])) {
            $joins[] = "INNER JOIN recipe_ingredients ri ON r.id = ri.recipe_id";
            $joins[] = "INNER JOIN ingredients i ON ri.ingredient_id = i.id";
        }

        // Add joins to query
        if (!empty($joins)) {
            $query .= " " . implode(" ", array_unique($joins));
        }

        // Filter by categories
        if (!empty($filters['category'])) {
            if (is_array($filters['category'])) {
                $categoryPlaceholders = [];
                foreach ($filters['category'] as $categoryId) {
                    $paramName = 'category_' . $paramCounter++;
                    $categoryPlaceholders[] = ':' . $paramName;
                    $params[$paramName] = $categoryId;
                }
                $conditions[] = "c.id IN (" . implode(',', $categoryPlaceholders) . ")";
            } else {
                $paramName = 'category_' . $paramCounter++;
                $conditions[] = "c.id = :" . $paramName;
                $params[$paramName] = $filters['category'];
            }
        }        // Filter by search term
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $paramName1 = 'search_name_' . $paramCounter++;
            $paramName2 = 'search_desc_' . $paramCounter++;
            $conditions[] = "(r.name LIKE :" . $paramName1 . " OR r.description LIKE :" . $paramName2 . ")";
            $params[$paramName1] = $searchTerm;
            $params[$paramName2] = $searchTerm;
        }

        // Filter by difficulty
        if (!empty($filters['difficulty'])) {
            if (is_array($filters['difficulty'])) {
                $difficultyPlaceholders = [];
                foreach ($filters['difficulty'] as $difficulty) {
                    $paramName = 'difficulty_' . $paramCounter++;
                    $difficultyPlaceholders[] = ':' . $paramName;
                    $params[$paramName] = $difficulty;
                }
                $conditions[] = "r.difficulty IN (" . implode(',', $difficultyPlaceholders) . ")";
            } else {
                $paramName = 'difficulty_' . $paramCounter++;
                $conditions[] = "r.difficulty = :" . $paramName;
                $params[$paramName] = $filters['difficulty'];
            }
        }

        $query .= " WHERE " . implode(" AND ", $conditions);
        $orderBy = "r.created_at DESC";
        $query .= " ORDER BY " . $orderBy;

        // Add LIMIT and OFFSET if specified
        if (!empty($filters['limit'])) {
            $query .= " LIMIT :limit";
            $params['limit'] = (int)$filters['limit'];
            if (!empty($filters['offset'])) {
                $query .= " OFFSET :offset";
                $params['offset'] = (int)$filters['offset'];
            }
        }

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }

    public function createRecipe($recipeData)
    {
        return $this->db->insert('recipes', $recipeData);
    }

    public function updateRecipe($id, $recipeData)
    {
        return $this->db->update('recipes', $recipeData, ['id' => $id]);
    }


    public function deleteRecipe($id)
    {
        return $this->db->update('recipes', ['deleted' => 1], ['id' => $id]);
    }

    public function softDeleteRecipe($id)
    {
        return $this->db->update('recipes', ['deleted' => 1], ['id' => $id]);
    }

    public function getUniqueDifficultyTypes()
    {
        $query = "SELECT DISTINCT difficulty
                  FROM recipes 
                  WHERE deleted = 0";
        $result = $this->db->select($query);
        return is_array($result) ? $result : [];
    }
    public function getRecipesByAllIngredients($filters)
    {
        if (is_array($filters) && !empty($filters)) {
            if (isset($filters['ingredient'])) {
                $ingredientIds = $filters['ingredient'];
            } else {
                $ingredientIds = $filters;
            }
        } else {
            return [];
        }

        if (empty($ingredientIds) || !is_array($ingredientIds)) {
            return [];
        }

        $ingredientIds = array_unique($ingredientIds);
        $ingredientCount = count($ingredientIds);
        $query = "SELECT DISTINCT r.*, u.username as owner_name
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id
                  INNER JOIN recipe_ingredients ri ON r.id = ri.recipe_id
                  INNER JOIN ingredients i ON ri.ingredient_id = i.id
                  WHERE r.deleted = 0 AND i.deleted = 0";

        $params = [];

        $paramCounter = 0;
        $ingredientPlaceholders = [];
        foreach ($ingredientIds as $ingredient) {
            $paramName = 'ingredient_' . $paramCounter++;
            $ingredientPlaceholders[] = ':' . $paramName;
            $params[$paramName] = $ingredient;
        }
        $query .= " AND i.id IN (" . implode(',', $ingredientPlaceholders) . ")";

        $query .= " GROUP BY r.id
                    HAVING COUNT(DISTINCT i.id) = :ingredient_count";
        $params['ingredient_count'] = $ingredientCount;

        $query .= " ORDER BY r.created_at DESC";

        if (is_array($filters) && !empty($filters['limit'])) {
            $query .= " LIMIT :limit";
            $params['limit'] = (int)$filters['limit'];

            if (!empty($filters['offset'])) {
                $query .= " OFFSET :offset";
                $params['offset'] = (int)$filters['offset'];
            }
        }

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }

    public function getRecipeById($id)
    {
        $query = "SELECT r.*, u.username as owner_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id 
                  WHERE r.id = :id AND r.deleted = 0";

        $result = $this->db->select($query, ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }
    public function getRecipeIngredients($recipeId)
    {
        $query = "SELECT i.*, ri.amount, u.unit_name
                  FROM ingredients i
                  INNER JOIN recipe_ingredients ri ON i.id = ri.ingredient_id
                  INNER JOIN units u ON ri.unit_id = u.id
                  WHERE ri.recipe_id = :recipe_id AND i.deleted = 0
                  ORDER BY ri.ingredient_id";

        $result = $this->db->select($query, ['recipe_id' => $recipeId]);
        return is_array($result) ? $result : [];
    }
    public function getRecipeCategories($recipeId)
    {
        $query = "SELECT c.*
                  FROM categories c
                  INNER JOIN recipe_categories rc ON c.id = rc.category_id
                  WHERE rc.recipe_id = :recipe_id AND c.deleted = 0
                  ORDER BY c.name";

        $result = $this->db->select($query, ['recipe_id' => $recipeId]);
        return is_array($result) ? $result : [];
    }

    public function getRecipesByOwnerId($ownerId, $limit = null, $offset = 0)
    {
        $query = "SELECT r.*, u.username as owner_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id 
                  WHERE r.owner_user_id = :owner_id AND r.deleted = 0 
                  ORDER BY r.created_at DESC";

        $params = ['owner_id' => $ownerId];

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }

    public function getRecipesByOwnerIdAndFilters($ownerId, $filters = [])
    {
        $query = "SELECT DISTINCT r.*, u.username as owner_name 
                  FROM recipes r 
                  LEFT JOIN users u ON r.owner_user_id = u.id";

        $joins = [];
        $conditions = ["r.owner_user_id = :owner_id", "r.deleted = 0"];
        $params = ['owner_id' => $ownerId];
        $paramCounter = 0;

        if (!empty($filters['category'])) {
            $joins[] = "INNER JOIN recipe_categories rc ON r.id = rc.recipe_id";
            $joins[] = "INNER JOIN categories c ON rc.category_id = c.id";
        }

        if (!empty($filters['ingredient'])) {
            $joins[] = "INNER JOIN recipe_ingredients ri ON r.id = ri.recipe_id";
            $joins[] = "INNER JOIN ingredients i ON ri.ingredient_id = i.id";
        }

        if (!empty($joins)) {
            $query .= " " . implode(" ", array_unique($joins));
        }

        if (!empty($filters['category'])) {
            if (is_array($filters['category'])) {
                $categoryPlaceholders = [];
                foreach ($filters['category'] as $categoryId) {
                    $paramName = 'category_' . $paramCounter++;
                    $categoryPlaceholders[] = ':' . $paramName;
                    $params[$paramName] = $categoryId;
                }
                $conditions[] = "c.id IN (" . implode(',', $categoryPlaceholders) . ")";
            } else {
                $paramName = 'category_' . $paramCounter++;
                $conditions[] = "c.id = :" . $paramName;
                $params[$paramName] = $filters['category'];
            }
        }

        if (!empty($filters['ingredient'])) {
            if (is_array($filters['ingredient'])) {
                $ingredientPlaceholders = [];
                foreach ($filters['ingredient'] as $ingredientId) {
                    $paramName = 'ingredient_' . $paramCounter++;
                    $ingredientPlaceholders[] = ':' . $paramName;
                    $params[$paramName] = $ingredientId;
                }
                $conditions[] = "i.id IN (" . implode(',', $ingredientPlaceholders) . ")";
            } else {
                $paramName = 'ingredient_' . $paramCounter++;
                $conditions[] = "i.id = :" . $paramName;
                $params[$paramName] = $filters['ingredient'];
            }
        }

        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $paramName1 = 'search_name_' . $paramCounter++;
            $paramName2 = 'search_desc_' . $paramCounter++;
            $conditions[] = "(r.name LIKE :" . $paramName1 . " OR r.description LIKE :" . $paramName2 . ")";
            $params[$paramName1] = $searchTerm;
            $params[$paramName2] = $searchTerm;
        }

        if (!empty($filters['difficulty'])) {
            if (is_array($filters['difficulty'])) {
                $difficultyPlaceholders = [];
                foreach ($filters['difficulty'] as $difficulty) {
                    $paramName = 'difficulty_' . $paramCounter++;
                    $difficultyPlaceholders[] = ':' . $paramName;
                    $params[$paramName] = $difficulty;
                }
                $conditions[] = "r.difficulty IN (" . implode(',', $difficultyPlaceholders) . ")";
            } else {
                $paramName = 'difficulty_' . $paramCounter++;
                $conditions[] = "r.difficulty = :" . $paramName;
                $params[$paramName] = $filters['difficulty'];
            }
        }

        $query .= " WHERE " . implode(" AND ", $conditions);
        $orderBy = "r.created_at DESC";
        $query .= " ORDER BY " . $orderBy;

        if (!empty($filters['limit'])) {
            $query .= " LIMIT :limit";
            $params['limit'] = (int)$filters['limit'];

            if (!empty($filters['offset'])) {
                $query .= " OFFSET :offset";
                $params['offset'] = (int)$filters['offset'];
            }
        }

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }
}
