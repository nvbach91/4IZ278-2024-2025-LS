<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#!">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (isset($_COOKIE['name']) && !empty($_COOKIE['name'])): ?>
                        <h3><?php echo htmlspecialchars($_COOKIE['name'], ENT_QUOTES, 'UTF-8');endif ?></h3>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#!">
                        Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if (isset($_COOKIE['name']) && !empty($_COOKIE['name'])): ?>
                    <li class="nav-item"><a class="nav-link" href="./cart.php">Basket</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>