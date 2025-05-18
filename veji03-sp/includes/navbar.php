<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/sp/index.php">MobilShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="/sp/index.php" class="nav-link">Domů</a></li>
                <li class="nav-item"><a href="/sp/cart.php" class="nav-link">Košík</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a href="/sp/profile.php" class="nav-link">Profil</a></li>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <li class="nav-item"><a href="/sp/admin/products.php" class="nav-link">Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a href="/sp/login.php" class="nav-link">Přihlásit</a></li>
                    <li class="nav-item"><a href="/sp/register.php" class="nav-link">Registrovat</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="/sp/logout.php" class="nav-link">Odhlásit</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>