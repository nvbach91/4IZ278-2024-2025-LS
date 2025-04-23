<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/~enga03/cv10/index.php">E-Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/~enga03/cv10/index.php">Home</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/~enga03/cv10/pages/profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~enga03/cv10/pages/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~enga03/cv10/pages/logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/~enga03/cv10/pages/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~enga03/cv10/pages/registration.php">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
</body>
</html>