<header class="header">
    <div class="header-content">
        <a href="./" class="logo">
            <img src="assets/logo_text.png" width="250px" alt="RecipeHub Logo">
        </a>        <div class="auth-buttons">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="./admin/recipeManagement.php" class="nav-item <?php echo $pageTitle == 'Recipe Management' ? 'active' : '' ?>">Admin - Recipe management</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="./logout" class="btn">Logout</a>
            <?php else: ?>
                <a href="./register" class="btn">Sign up</a>
                <a href="./login" class="btn btn-primary">Log in</a>
            <?php endif; ?>
        </div>
    </div>
</header>