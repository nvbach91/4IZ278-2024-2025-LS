<?php 

$loggedIn = false;
$privilege = 0;
if (isset($_COOKIE['loginSuccess'])) {
    $loggedIn = true;
}
if (isset($_SESSION["privilege"])) {
    $privilege = $_SESSION["privilege"];
}

?>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h1 class="text-light"><a href="./index.php"> Outdoor gear shop</h1>
            <div>
                <?php if($loggedIn) :?>
                    <?php if($privilege > 1) :?>
                        <a class="btn btn-primary" href="./admin.php">Admin</a>
                    <?php endif; ?>
                    <a class="btn btn-primary" href="./gearlists.php">Gearlisty</a>
                    <a class="btn btn-primary" href="./profile.php">Profil</a>
                    <a class="btn btn-primary" href="./cart.php">Košík</a>
                    <a class="btn btn-primary" href="./profile.php">Profil</a>
                    <a class="btn btn-primary" href="./scripts/logout.php">Odhlásit se</a>
                    <p>privilege:<?php echo $privilege;?></p>
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
            <a class="btn btn-primary" href="./products.php">Stany</a>
            <a class="btn btn-primary" href="./products.php">Spacáky</a>
            <a class="btn btn-primary" href="./products.php">Karimatky</a>
            <a class="btn btn-primary" href="./products.php">Batohy</a>
            <a class="btn btn-primary" href="./products.php">Oblečení</a>
            <a class="btn btn-primary" href="./products.php">Ostatní vybavení</a>
        </div>
    </div>
</div>

