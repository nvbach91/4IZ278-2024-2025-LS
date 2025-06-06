<?php
require_once __DIR__ . '/../db/Database.php';

class Favorite
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserFavoriteRecipes($userId, $limit = null, $offset = 0)
    {
        $query = "SELECT r.*, u.username as owner_name 
                  FROM recipes r 
                  INNER JOIN user_favorites uf ON r.id = uf.recipe_id
                  LEFT JOIN users u ON r.owner_user_id = u.id 
                  WHERE uf.user_id = :user_id AND r.deleted = 0 
                  ORDER BY r.created_at DESC";

        $params = ['user_id' => $userId];

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }

    public function getUserFavoriteRecipesByFilters($userId, $filters)
    {
        $query = "SELECT DISTINCT r.*, u.username as owner_name 
                  FROM recipes r 
                  INNER JOIN user_favorites uf ON r.id = uf.recipe_id
                  LEFT JOIN users u ON r.owner_user_id = u.id";

        $joins = [];
        $conditions = ["uf.user_id = :user_id", "r.deleted = 0"];
        $params = ['user_id' => $userId];
        $paramCounter = 0;
        
        if (!empty($filters['category'])) {
            $joins[] = "INNER JOIN recipe_categories rc ON r.id = rc.recipe_id";
            $joins[] = "INNER JOIN categories c ON rc.category_id = c.id";
        }

        if (!empty($joins)) {
            $query .= " " . implode(" ", array_unique($joins));
        }

        // filter by categories
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

        // filter by search term
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $paramName1 = 'search_name_' . $paramCounter++;
            $paramName2 = 'search_desc_' . $paramCounter++;
            $conditions[] = "(r.name LIKE :" . $paramName1 . " OR r.description LIKE :" . $paramName2 . ")";
            $params[$paramName1] = $searchTerm;
            $params[$paramName2] = $searchTerm;
        }

        // filter by difficulty
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
        $query .= " ORDER BY r.created_at DESC";

        $result = $this->db->select($query, $params);
        return is_array($result) ? $result : [];
    }

    public function addToFavorites($userId, $recipeId)
    {
        return $this->db->insert('user_favorites', [
            'user_id' => $userId,
            'recipe_id' => $recipeId
        ]);
    }

    public function removeFromFavorites($userId, $recipeId)
    {
        return $this->db->delete('user_favorites', [
            'user_id' => $userId,
            'recipe_id' => $recipeId
        ]);
    }

    public function isFavorite($userId, $recipeId)
    {
        $query = "SELECT COUNT(*) as count FROM user_favorites WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $result = $this->db->select($query, [
            'user_id' => $userId,
            'recipe_id' => $recipeId
        ]);
        return is_array($result) && !empty($result) ? (int)$result[0]['count'] > 0 : false;
    }
}
