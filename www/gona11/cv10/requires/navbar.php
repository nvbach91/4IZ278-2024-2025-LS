<?php 
$loggedIn = false;
if (isset($_COOKIE['loginSuccess'])) {
    $loggedIn = true;
}

session_start();
$privilege = 0; // Default privilege level
if($loggedIn && isset($_SESSION["privilege"])) {
    $privilege = $_SESSION["privilege"];
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <h1 class="text-light">Good stuff shop.</h1>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <?php if($loggedIn): ?>
                    <?php if($privilege === 3): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./user-privileges.php">User Privileges</a>
                        </li>
                    <?php endif; ?>
                    <?php if($privilege >= 2): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./add-item.php">Add an item</a>
                        </li>
                    <?php endif; ?>
                    <?php if($privilege >= 1): ?>
                        <li class="nav-item">
                        <a class="nav-link" href="./cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(!$loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./register.php">Register</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>