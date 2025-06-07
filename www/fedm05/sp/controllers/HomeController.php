<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../models/Recipe.php';

class HomeController extends BaseController {
      public function home() {
        $recipeModel = new Recipe();
        
        // get 12 latest recipes for the home page
        $recipes = $recipeModel->getAllRecipes(12) ?? [];
        
        // add favorite status to recipes for logged in users
        $recipes = $this->addFavoriteStatusToRecipes($recipes);
        
        $data = [
            'pageTitle' => 'Home',
            'recipes' => $recipes,
        ];
        $this->render('home', $data);
    }
}
?>