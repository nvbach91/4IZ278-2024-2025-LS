<?php
    $current_page = basename($_SERVER['PHP_SELF']);
    if(!isset($_SESSION)) { 
        session_start(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tom's games</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Tom's games</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                        </li>
                        <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=1){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>" href="cart.php">Cart</a>
                        </li>
                        <?php } ?>
                        <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=2){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'edit-items.php' ? 'active' : ''; ?>" href="edit-items.php">Edit items</a>
                        </li>
                        <?php } ?>
                        <?php if(isset($_SESSION['user'])&&$_SESSION['user']['privilege']>=3){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'user-privileges.php' ? 'active' : ''; ?>" href="user-privileges.php">Users</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item <?php echo $current_page == 'account.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="edit-user.php">
                                <?php echo $_SESSION['user']['name']?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'login.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user']) ? "logout.php" : "login.php"?>">
                                <?php echo isset($_SESSION['user']) ? "Logout" : "Login"?>
                            </a>
                        </li>
                        <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'register.php' ? 'active' : ''; ?>" href="register.php">Register</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
