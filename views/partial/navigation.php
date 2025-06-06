<?php
# Dropdown menu
require_once __DIR__ . '/../../models/Category.php';
$categoryModel = new Category();
$mealCategories = $categoryModel->getCategoriesByType('meal');
?>
<nav class="navigation">
    <div class="nav-content">
        <div class="nav-menu">
            <a href="./" class="nav-item <?php echo $pageTitle == 'Home' ? 'active' : '' ?>">Home</a>
            <div class="recipes-dropdown">
                <a href="./recipes" class="nav-item <?php echo $pageTitle == 'Recipes' ? 'active' : '' ?>">Recipes</a>
                <div class="dropdown-content">
                    <div class="dropdown-header">Categories</div>
                    <?php foreach ($mealCategories as $category): ?>
                        <a href="./recipes?action=add_filter&filter_type=category&filter_value=<?php echo urlencode($category['id']); ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>            <a href="./cooknow" class="nav-item <?php echo $pageTitle == 'Cook Now' ? 'active' : '' ?>">Cook Now</a>
            <a href="./favourites" class="nav-item <?php echo $pageTitle == 'My Favourites' ? 'active' : '' ?>">My Favourites</a>
            <a href="./myrecipes" class="nav-item <?php echo $pageTitle == 'My Recipes' ? 'active' : '' ?>">My Recipes</a>
        </div>
        <div class="search-bar">
            <form method="GET" action="./recipes" class="search-form">
                <input type="search"
                    name="search"
                    placeholder="Search all recipes..."
                    class="search-input"
                    value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                <button type="submit" class="search-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>