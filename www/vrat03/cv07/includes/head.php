<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>cv07-eshop</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">My e-shop</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item <?php echo $current_page == 'edit-items.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="edit-items.php">Edit items</a>
                        </li>
                        <li class="nav-item <?php echo $current_page == 'login.php' ? 'active' : ''; ?>">
                            <a class="nav-link " href="<?php echo isset($_COOKIE['name']) ? "logout.php" : "login.php"?>">
                                <?php echo isset($_COOKIE['name']) ? "Logout" : "Login"?>
                            </a>
                        </li>
                        <?php if (isset($_COOKIE['name'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <?php echo $_COOKIE['name']?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>