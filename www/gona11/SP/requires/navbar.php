<?php 

$loggedIn = false;
$privilege = 0;
if (isset($_COOKIE["loginSuccess"])) {
    $loggedIn = true;
}
if (isset($_SESSION["privilege"])) {
    $privilege = $_SESSION["privilege"];
}

?>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h1 class="text-light"><a class="main_logo" href="./index.php">OutdoorHub</h1>
            <div>
                <?php if($loggedIn) :?>
                    <?php if($privilege > 1) :?>
                        <a class="btn btn-primary" href="./admin.php">Admin</a>
                    <?php endif; ?>
                    <a class="btn btn-primary" href="./cart.php">Košík</a>
                    <a class="btn btn-primary" href="./profile.php">Profil</a>
                    <a class="btn btn-primary" href="./scripts/logout.php">Odhlásit se</a>
                <?php else :?>
                    <a class="btn btn-primary ml-2" href="./login.php">Přihlásit se</a>
                    <a class="btn btn-primary ml-2" href="./register.php">Registrovat se</a>
                <?php endif; ?>
            </div>
        </div>
    </div>    
</nav>
<div class="bg-dark pt-2 pb-4">
    <div class="container-lg">
        <div class="d-flex justify-content-between bg-dark">
            <a class="btn btn-primary btn-navbar" href="./products.php?category=1">Stany</a>
            <a class="btn btn-primary btn-navbar" href="./products.php?category=2">Spacáky</a>
            <a class="btn btn-primary btn-navbar" href="./products.php?category=3">Karimatky</a>
            <a class="btn btn-primary btn-navbar" href="./products.php?category=4">Batohy</a>
            <a class="btn btn-primary btn-navbar" href="./products.php?category=5">Oblečení</a>
            <a class="btn btn-primary btn-navbar" href="./products.php?category=6">Ostatní vybavení</a>
        </div>
    </div>
</div>

