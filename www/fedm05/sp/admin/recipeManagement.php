<?php
session_start();
require_once __DIR__ . '/../controllers/AdminController.php';
$adminController = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $adminController->deleteRecipe();
}
$result = $adminController->recipeManagement();
extract($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipeHub<?php echo $pageTitle != '' ? ' | ' . $pageTitle : '' ?></title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php
        include __DIR__ . '/../views/partial/headerAdmin.php';
        include __DIR__ . '/../views/partial/navigationAdmin.php';
        ?>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Recipe Management</h1>
                <div class="admin-search">
                    <form method="GET" action="" class="search-form">                        <input type="search"
                            name="search"
                            placeholder="Search recipes in admin..."
                            class="search-input"
                            value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <button type="submit" class="search-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                        </button>
                    </form>
                </div>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                    <?php unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="admin-recipe-list">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="admin-recipe-item">
                            <div class="recipe-image-container">
                                <img src="<?php echo htmlspecialchars("../" . $recipe['img']); ?>"
                                    alt="Recipe image"
                                    class="recipe-image">
                            </div>
                            <div class="recipe-info">
                                <h3 class="recipe-name"><?php echo htmlspecialchars($recipe['name']); ?></h3>
                                <p class="recipe-author">by <?php echo htmlspecialchars($recipe['owner_name']); ?></p>
                            </div>
                            <div class="recipe-actions">
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this recipe?');" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-recipes">
                        <p>No recipes found.</p>
                    </div>
                <?php endif; ?>
                
                <!-- Pagination -->
                <?php require __DIR__ . '/../views/partial/pagination.php'; ?>
            </div>
        </main>

        <!-- Footer -->
        <?php include __DIR__ . '/../views/partial/footer.php'; ?>
    </div>
    <script src="../script/main.js"></script>
</body>

</html>