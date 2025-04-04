
<?php 
$loggedIn = false;
if (isset($_COOKIE['loginSuccess'])) {
    $loggedIn = true;
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
                <li class="nav-item">
                    <a class="nav-link" href="./cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./add-item.php">Add an item</a>
                </li>
                <?php if($loggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>