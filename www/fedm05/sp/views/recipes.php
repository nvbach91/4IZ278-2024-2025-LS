<!DOCTYPE html>
<?php
include __DIR__ . '/partial/head.php';

// Get current filters from session for display purposes
$currentFilters = $_SESSION[$pageKey] ?? [];

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
        <!-- Header -->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?>

        <!-- Recipes Content -->
        <main class="recipes-main">
            <div class="recipes-layout">
                <!-- Filters Sidebar -->
                <aside class="filters-sidebar">
                    <div class="filters-section">
                        <h3 class="filters-title">Filters</h3>

                        <!-- Active Filters -->
                        <?php if (!empty($activeFilters)): ?>
                            <div class="active-filters">
                                <h4 class="active-filters-title">Active Filters</h4>
                                <div class="active-filters-list">
                                    <?php foreach ($activeFilters as $filterType => $filterValues): ?>
                                        <?php
                                        $values = is_array($filterValues) ? $filterValues : [$filterValues];
                                        ?>
                                        <?php foreach ($values as $filterValue): ?>
                                            <?php if (!is_array($filterValue)): 
                                            ?>
                                                <div class="active-filter-tag">
                                                    <span class="filter-tag-text">
                                                        <?php
                                                        if ($filterType === 'category') {
                                                            $categoryName = '';
                                                            foreach ($categories as $category) {
                                                                if ($category['id'] == $filterValue) {
                                                                    $categoryName = $category['name'];
                                                                    break;
                                                                }
                                                            }
                                                            echo htmlspecialchars($categoryName);
                                                        } else {
                                                            echo htmlspecialchars($filterValue);
                                                        }
                                                        ?>
                                                    </span>
                                                    <a href="<?php echo htmlspecialchars(generateHref($currentFilters, $filterType, $filterValue)) ?>"
                                                        class="remove-filter" title="Remove filter">x</a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                                <a href="?action=clear_filters" class="clear-all">Clear all filters</a>
                            </div>
                        <?php endif; ?>

                        <!-- Category Filters -->
                        <?php if (!empty($categoryTypes)): ?>
                            <?php foreach ($categoryTypes as $type): ?>
                                <div class="filter-group">
                                    <h4 class="filter-group-title"><?php echo htmlspecialchars($type) ?></h4>
                                    <?php foreach ($categories as $category): ?>
                                        <?php if ($category['type'] === $type): ?>
                                            <div class="filter-options">
                                                <a href="<?php echo htmlspecialchars(generateHref($currentFilters, "category", $category['id'])) ?>"
                                                    class="filter-option <?php echo isActiveFilter($currentFilters, "category", $category['id']) ? 'active' : ''; ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Difficulty Filters -->
                        <div class="filter-group">
                            <h4 class="filter-group-title">Difficulty</h4>
                            <?php foreach ($difficultyTypes as $difficulty): ?>
                                <div class="filter-options">
                                    <a href="<?php echo htmlspecialchars(generateHref($currentFilters, "difficulty", $difficulty)) ?>"
                                        class="filter-option <?php echo isActiveFilter($currentFilters, "difficulty", $difficulty) ? 'active' : ''; ?>">
                                        <?php echo htmlspecialchars($difficulty); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Cook Time Filters -->
                        <div class="filter-group">
                            <h4 class="filter-group-title">Cook Time</h4>
                            <?php foreach ($cookTimeFilters as $index => $timeFilter): ?>
                                <div class="filter-options">
                                    <a href=""
                                        class="filter-option">
                                        <?php echo htmlspecialchars($timeFilter['label']); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside> 
                <div class="recipes-content">
                    <div class="page-header">
                        <h1 class="page-title">
                            <?php if (!empty($activeFilters['search'])): ?>
                                Search Results for "<?php echo htmlspecialchars($activeFilters['search']); ?>"
                            <?php elseif (!empty($activeFilters)): ?>
                                Filtered Recipes
                            <?php else: ?>
                                <?php echo htmlspecialchars($pageTitle); ?>
                            <?php endif; ?>
                        </h1>
                        <!-- if the page is my recipes, add a button -->
                        <?php if ($pageTitle === 'My Recipes'): ?>
                            <div class="header-actions">
                                <a href='./add-recipe' class="btn btn-primary">Add a Recipe</a>
                            </div>
                        <?php endif; ?>
                        <div class="results-info">
                            <?php if ($pagination['totalRecipes'] > 0): ?>
                                <span class="results-count">
                                    Showing <?php echo (($pagination['currentPage'] - 1) * $pagination['recipesPerPage']) + 1; ?>-<?php echo min($pagination['currentPage'] * $pagination['recipesPerPage'], $pagination['totalRecipes']); ?> of <?php echo $pagination['totalRecipes']; ?> recipes
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($activeFilters)): ?>
                                <a href="?action=clear_filters" class="clear-all">Clear all filters</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- grid of recipe cards -->
                    <div class="recipes-grid">
                        <?php
                        require __DIR__ . '/partial/recipe-cards.php';
                        ?>
                    </div>
                    <!-- Pagination -->
                    <?php require __DIR__ . '/partial/pagination.php'; ?>
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