<?php
$adminLoggedIn = !empty($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin';
$adminName = $_SESSION['user_name'] ?? '';
$adminAvatar = $_SESSION['user_avatar'] ?? '';
if (!$adminLoggedIn) {
    header('Location: /~adaj12/test/pages/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin | Deskovkárna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/~adaj12/test/assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/~adaj12/test/admin/admin.php">Deskovkárna <span class="text-warning">Admin</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="/~adaj12/test/admin/admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/~adaj12/test/admin/orders.php">Správa objednávek</a></li>
                <li class="nav-item"><a class="nav-link" href="/~adaj12/test/admin/products.php">Správa katalogu</a></li>
                <li class="nav-item d-flex align-items-center ms-3">
                    <!-- Odhlásit se -->
                    <a class="nav-link text-danger px-2" href="/~adaj12/test/functions/php/logout.php" style="font-weight:bold;">
                        Odhlásit se
                    </a>
                    <!-- Avatar + admin -->
                    <span class="d-flex align-items-center ms-2" style="font-weight:bold; color:#fff;">
                        <?php if ($adminAvatar): ?>
                            <img src="<?= htmlspecialchars($adminAvatar) ?>" alt="Avatar" style="width:28px;height:28px;border-radius:50%;object-fit:cover;margin-right:7px;">
                        <?php else: ?>
                            <span style="width:28px;height:28px;display:inline-block;background:#eee;border-radius:50%;text-align:center;line-height:28px;font-size:1.1em;color:#888;margin-right:7px;">
                                <i class="bi bi-person-circle"></i>
                            </span>
                        <?php endif; ?>
                        admin
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container">
