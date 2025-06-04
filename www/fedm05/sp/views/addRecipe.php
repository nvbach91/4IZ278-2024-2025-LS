<!DOCTYPE html>
<?php include __DIR__ . '/partial/head.php'; ?>

<body>
    <div class="container">
        <!-- Header -->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';        ?>
        <main class="recipe-detail-main">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="" enctype="multipart/form-data" class="add-recipe-form">
                <div class="recipe-detail-left">
                    <input type="text" name="recipe_name" placeholder="Enter recipe name" class="recipe-detail-name" required>
                    <h2>Ingredients</h2>
                    <div class="portion-controller">
                        <span class="portion-label">Portions:</span>
                        <input type="number" name="portions" id="portions" class="portion-value" value="1" min="1" max="50" required>
                    </div>
                    <div id="ingredients-container">
                        <div class="ingredient-item">
                            <input type="text" name="ingredient_amount[]" placeholder="1" class="ingredient-amount" required>
                            <input type="text" name="ingredient_unit[]" placeholder="cup" class="ingredient-unit" required>
                            <input type="text" name="ingredient_name[]" placeholder="Ingredient name" class="ingredient-name" required>
                        </div>
                    </div>
                    <button type="button" onclick="addIngredient()" class="add-ingredient-btn">+ Add More Ingredients</button>

                    <h2>Recipe Details</h2>
                    <div class="recipe-details-section">
                        <div class="detail-group">
                            <label for="difficulty" class="detail-label">Difficulty Level:</label>
                            <select name="difficulty" id="difficulty" class="recipe-difficulty-enter" required>
                                <option value="">Select difficulty</option>
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>

                        <div class="detail-group">
                            <label for="cooking_time" class="detail-label">Cooking Time (minutes):</label>
                            <input type="number" name="cooking_time" id="cooking_time" placeholder="30" class="recipe-time-enter" min="1" max="600" required>
                        </div>
                    </div>
                </div>
                <div class="recipe-detail-right">
                    <div style="margin-bottom: 16px;">
                        <label for="recipe_image" style="display: block; font-size: 14px; color: #666; margin-bottom: 8px;">Recipe Image:</label>
                        <input type="file" name="recipe_image" id="recipe_image" accept="image/*" class="recipe-image-input">
                    </div>
                    <img src="assets/food-placeholder.png" alt="Recipe image" class="recipe-image">
                    <h2>Instructions</h2>
                    <textarea name="instructions" placeholder="Enter step-by-step cooking instructions..." class="recipe-description-input" rows="8" required></textarea>
                </div>

                <button type="submit" name="submit_recipe" class="btn btn-primary save-recipe-btn">
                    Save Recipe
                </button>
            </form>
        </main>

        <!-- Footer -->
        <?php include __DIR__ . '/partial/footer.php'; ?>
    </div>

    <script src="script/main.js"></script>
</body>

</html>