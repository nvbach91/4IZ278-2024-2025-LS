<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
define('BASE_URL', '/4IZ278/DU/du06/');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation-->
    <!-- Domovskou stránku, Košík, Profil, Login, Logout-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">My e-shop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
                    </li>
                    <li class="nav-item <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/includes/cart.php">Cart</a>
                    </li>
                    <li class="nav-item <?php echo $current_page == 'edit-items.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">Profile</a>
                    </li>
                    <li class="nav-item <?php echo $current_page == 'login.php' ? 'active' : ''; ?>">
                        <a class="nav-link " href="<?php echo BASE_URL . 'includes/'; ?><?php echo isset($_COOKIE['name']) ? "logout.php" : "login.php" ?>">
                            <?php echo isset($_COOKIE['name']) ? "Logout" : "Login" ?>
                        </a>
                    </li>
                    <?php if (isset($_COOKIE['name'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <?php echo $_COOKIE['name'] ?>
                            </a>
                        </li>
                        <?php if ($_SESSION['privilege'] == 3): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/includes/user-privilege.php">
                                    Users maganement
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>