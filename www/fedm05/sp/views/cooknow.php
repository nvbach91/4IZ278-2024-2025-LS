<!DOCTYPE html>
<?php
include __DIR__ . '/partial/head.php';

$currentFilters = $_SESSION[$pageKey] ?? [];
// selectedIngredients array for display
$selectedIngredients = [];
if (!empty($currentFilters['ingredient'])) {
    foreach ($currentFilters['ingredient'] as $selectedIngredientId) {
        foreach ($ingredients as $ingredient) {
            if ($ingredient['id'] == $selectedIngredientId) {
                $selectedIngredients[] = $ingredient['name'];
                break;
            }
        }
    }
}

function isActiveFilter($currentFilters, $filterCategory, $filterValue)
{
    return isset($currentFilters[$filterCategory]) && in_array($filterValue, $currentFilters[$filterCategory]);
}

function generateHref($currentFilters, $filterCategory, $filterValue)
{
    if (isActiveFilter($currentFilters, $filterCategory, $filterValue)) {
        return "?action=remove_filter&filter_type={$filterCategory}&filter_value=" . urlencode($filterValue);
    } else {
        return "?action=add_filter&filter_type={$filterCategory}&filter_value=" . urlencode($filterValue);
    }
}

?>

<body>
    <div class="container">
        <!-- Header and navigation-->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?>
        <!-- Cook Now Content -->
        <main class="cooknow-main">
            <div class="cooknow-layout">
                <!-- Ingredients Sidebar -->
                <aside class="ingredients-sidebar">
                    <div class="ingredients-section">
                        <h3 class="ingredients-title">Select Ingredients</h3>
                        <?php if (!empty($currentFilters['ingredient'])): ?>
                            <div class="selected-ingredients">
                                <h4>Selected:</h4>
                                <div class="selected-tags">
                                    <?php foreach ($currentFilters['ingredient'] as $selectedIngredientId): ?>
                                        <?php
                                        $ingredientName = '';
                                        foreach ($ingredients as $ingredient) {
                                            if ($ingredient['id'] == $selectedIngredientId) {
                                                $ingredientName = $ingredient['name'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <?php if ($ingredientName): ?>
                                            <a href="<?php echo generateHref($currentFilters, 'ingredient', $selectedIngredientId) ?>" class="selected-tag">
                                                <?php echo htmlspecialchars($ingredientName) ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <a href="?action=clear_filters" class="clear-all">Clear All</a>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($ingredientTypes as $type): ?>
                            <h4 class="ingredient-group-title"><?php echo htmlspecialchars($type) ?></h4>
                            <div class="ingredient-group">
                                <?php foreach ($ingredients as $ingredient): ?>
                                    <?php if ($ingredient['category'] !== $type) continue; ?>
                                    <a
                                        href="<?php echo generateHref($currentFilters, 'ingredient', $ingredient['id']) ?>"
                                        class="ingredient-option <?php echo isActiveFilter($currentFilters, 'ingredient', $ingredient['id']) ? 'active' : '' ?>">
                                        <?php echo htmlspecialchars($ingredient['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </aside>

                <div class="cooknow-content">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">
                            <?php if (empty($selectedIngredients)): ?>
                                Cook Now - Select Your Ingredients
                            <?php else: ?>
                                Recipes with <?php echo implode(', ', array_map('ucfirst', $selectedIngredients)); ?>
                            <?php endif; ?>
                        </h1> <?php if (!empty($selectedIngredients)): ?>
                            <div class="results-count">
                                <span class="count">Found <?php echo $pagination['totalRecipes'] ?> recipes</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="recipes-grid">
                        <?php include __DIR__ . '/partial/recipe-cards.php'; ?>
                    </div>

                    <!-- Pagination -->
                    <?php include __DIR__ . '/partial/pagination.php'; ?>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php
        include __DIR__ . '/partial/footer.php';
        ?>
    </div>
    <script src="script/main.js"></script>
</body>

</html>