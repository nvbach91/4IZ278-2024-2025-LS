<!DOCTYPE html>
<?php include __DIR__ . '/partial/head.php'; ?>

<body>
    <div class="container">
        <!-- Header -->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?>

        <main class="recipe-detail-main">
            <?php if (isset($recipe)): ?> 
                <div class="recipe-detail-left">
                    <div class="recipe-actions">
                        <button class="btn btn-primary print-recipe" onclick="window.print()">
                            Print Recipe
                        </button>
                    </div>
                    <h1 class="recipe-detail-name"><?php echo $recipe["name"] ?></h1>
                    
                    <!-- recipe info -->
                    <div class="recipe-meta-info">
                        <div class="meta-item">
                            <span class="meta-label">Difficulty:</span>
                            <span class="meta-value difficulty-<?php echo strtolower($recipe['difficulty']); ?>"><?php echo htmlspecialchars($recipe['difficulty']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Cooking Time:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($recipe['cooktime']); ?> minutes</span>
                        </div>
                    </div>

                    <h2>Ingredients</h2>
                    <div class="portion-controller">
                        <span class="portion-label">Portions:</span>
                        <button class="btn btn-secondary portion-decrease">-</button>
                        <span class="portion-value"><?php echo $recipe["portions"] ?></span>
                        <button class="btn btn-secondary portion-increase">+</button>
                    </div> <?php foreach ($ingredients as $ingredient): ?>
                        <div class="ingredient-item" data-original-amount="<?php echo $ingredient['amount'] ?>" data-unit="<?php echo htmlspecialchars($ingredient["unit_name"]) ?>">
                            <span class="ingredient-amount"><?php echo htmlspecialchars(round($ingredient['amount'], 1) . ' ' . $ingredient["unit_name"]) ?></span>
                            <span class="ingredient-name"><?php echo htmlspecialchars($ingredient['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="recipe-detail-right">
                    <img src="assets/food-placeholder.png" alt="Recipe image" class="recipe-image">
                    <h2>Instructions</h2>
                    <div class="recipe-description"><?php echo htmlspecialchars($recipe["description"]) ?></div>
                </div>
            <?php else: ?>
                <!-- recipe not found -->
                <div class="recipe-not-found">
                    <div class="not-found-content">
                        <h1>Recipe Not Found</h1>
                        <p>Sorry, the recipe you're looking for doesn't exist or has been removed.</p>
                        <a href="recipes" class="btn btn-primary">Browse All Recipes</a>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <!-- Footer -->
        <?php include __DIR__ . '/partial/footer.php'; ?>
    </div>

    <script src="script/main.js"></script>
</body>

</html>