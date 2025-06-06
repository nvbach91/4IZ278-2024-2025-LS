<?php
require_once __DIR__ . '/../models/Favorite.php';

class BaseController {
    protected function render($viewPath, $data = []) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // set data to variables for views
        extract($data);
        
        // view path
        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';
        
        // 
        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            echo "View not found: " . $viewPath;
        }
    }
    
    protected function addFavoriteStatusToRecipes($recipes) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // only add favorite status if user is logged in
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return $recipes;
        }
        
        if (empty($recipes)) {
            return $recipes;
        }
        
        $favoriteModel = new Favorite();
        $userId = $_SESSION['user_id'];
        
        // add favorite status to each recipe
        foreach ($recipes as &$recipe) {
            $recipe['is_favorite'] = $favoriteModel->isFavorite($userId, $recipe['id']);
        }
        
        return $recipes;
    }
}
?>
