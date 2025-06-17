<?php

$isLoggedIn = isset($_SESSION['user']);
$isAdmin = $isLoggedIn && $_SESSION['user']['is_admin'] == 1;
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand">MobilShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!$isAdmin): ?>
                    <li class="nav-item"><a href="index.php" class="nav-link">Domů</a></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link">Košík (<?= $cartCount ?>)</a></li>
                <?php endif; ?>
                <?php if ($isLoggedIn && !$isAdmin): ?>
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profil</a></li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a href="admin/products.php" class="nav-link">Produkty</a></li>
                    <li class="nav-item"><a href="admin/orders.php" class="nav-link">Objednávky</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (!$isLoggedIn): ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Přihlásit</a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link">Registrovat</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Odhlásit</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>