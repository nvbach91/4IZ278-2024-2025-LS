<?php
$name = $_COOKIE['name'] ?? null;
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Fruit Shop</title>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Fruit Shop</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item <?php echo $currentPage === 'cart.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>

                <?php if ($name): ?>
                    <li class="nav-item <?php echo $currentPage === 'logout.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="logout.php">Log out</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-light">User: <?php echo htmlspecialchars($name); ?></span>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?php echo $currentPage === 'login.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>