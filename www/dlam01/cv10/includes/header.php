<?php @session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Caw</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="icons/HK_icon.webp" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <div id="holder">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="./index.php">My store</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <?php if (empty($_SESSION["email"])): ?>
                            <li class="nav-item <?= $current_page == 'index.php' ? 'active' : ''; ?>"><a class="nav-link" href=".">Home</a></li>
                            <li class="nav-item <?php echo $current_page == 'login.php' ? 'active' : ''; ?>"><a class="nav-link" href="./login.php">Login</a></li>
                            <li class="nav-item <?php echo $current_page == 'register.php' ? 'active' : ''; ?>"><a class="nav-link" href="./register.php">Register</a></li>
                        <?php else: ?>
                            <li class="nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>"><a class="nav-link" href=".">Home</a></li>
                            <?php if ($_SESSION["privilege"] == 3): ?>
                                <li class="nav-item <?php echo $current_page == 'user-privileges.php' ? 'active' : ''; ?>"><a class="nav-link" href="./user-privileges.php">Administration</a></li>
                                <li class="nav-item <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>"><a class="nav-link" href="./cart.php">Cart</a></li>
                            <?php endif; ?>
                            <li class="nav-item <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>"><a class="nav-link" href="./profile.php">Profile</a></li>
                            <li class="nav-item <?php echo $current_page == 'logout.php' ? 'active' : ''; ?>"><a class="nav-link" href="./logout.php">Sign out</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="body">