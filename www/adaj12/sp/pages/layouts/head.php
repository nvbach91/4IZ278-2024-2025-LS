<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userLoggedIn = !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userAvatar = $_SESSION['user_avatar'] ?? '';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Vítejte v e-shopu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/~adaj12/test/assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/~adaj12/test/index.php">Deskovkárna</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/~adaj12/test/index.php">Domů</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~adaj12/test/pages/products.php">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~adaj12/test/pages/user.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~adaj12/test/pages/cart.php">Košík</a>
                </li>
                <?php if ($userLoggedIn): ?>
                    <!-- Avatar + menu -->
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if ($userAvatar): ?>
                                <img src="<?= htmlspecialchars($userAvatar) ?>" alt="Avatar" style="width:34px;height:34px;border-radius:50%;object-fit:cover;margin-right:7px;">
                            <?php else: ?>
                                <span style="width:34px;height:34px;display:inline-block;background:#ddd;border-radius:50%;text-align:center;line-height:34px;font-size:1.2em;color:#888;margin-right:7px;">
                                    <i class="bi bi-person-circle"></i>
                                </span>
                            <?php endif; ?>
                            <span><?= htmlspecialchars($userName) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/~adaj12/test/pages/user.php">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/~adaj12/test/functions/php/logout.php">Odhlásit se</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/~adaj12/test/pages/login.php">Přihlášení</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/~adaj12/test/pages/register.php">Registrace</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container">
