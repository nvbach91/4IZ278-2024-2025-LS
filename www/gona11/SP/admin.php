<?php 
    require __DIR__ . "/includes/head.php"; 
    require __DIR__ . "/requires/navbar.php"; 

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }
?>

<div class="container">
    <?php if ($loggedIn && $privilegeLevel > 1): ?>
        <h1 class="mt-3 text-align">Správa eshopu</h1>
        <p class="lead text-align">Správa uživatelů, objednávek a všech produktů na jednom místě.</p>
        <div class="d-flex flex-column align-items-center mt-4">
            <a class="btn btn-secondary m-2" href="./products.php">Produkty</a>
            <a class="btn btn-secondary m-2" href="./orders.php">Přehled objednávek</a>
            <a class="btn btn-secondary m-2" href="./users.php">Uživatelé</a>
        </div>
        <a href="/scripts/logout.php"></a>
    <?php else: ?>
        <div class="alert alert-danger mt-3">Nemáte oprávnění pro přístup k této stránce.</div>
        <a class="btn btn-primary m-3" href="./index.php">Zpět na hlavní stránku</a>
    <?php endif; ?>
</div>

<?php require __DIR__ . "/includes/foot.php"; ?>