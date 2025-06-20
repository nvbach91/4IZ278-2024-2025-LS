<?php include __DIR__ . '/../prefix.php'; ?>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION)) {
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
    <link rel="icon" type="image/x-icon" href="<?php echo $urlPrefix ?>/image/favicon-white.ico" />
    <link rel="stylesheet" href="<?php echo $urlPrefix ?>/css/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&display=block&icon_names=account_circle,add_circle,add_shopping_cart,category,delete,download,edit,filter_alt,filter_alt_off,home,list_alt,lock,login,logout,manage_accounts,overview,save,shop,shopping_cart,shopping_cart_checkout" />
</head>

<body style="padding-top: 50px;">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark  fixed-top">
        <div class="container mb-0">
            <a class="navbar-brand" href="<?php echo $urlPrefix ?>/index.php">
                <img src="<?php echo $urlPrefix ?>/image/icon-white.png" width="30" height="30" class="d-inline-block align-top" alt="">
                Tom's games
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto">
                    <!--Home-->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/index.php">
                            <span class="material-symbols-outlined">home</span>
                            Home
                        </a>
                    </li>

                    <!--Cart-->
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['privilege'] >= 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/cart.php">
                                <span class="material-symbols-outlined">shopping_cart</span>
                                Cart
                            </a>
                        </li>
                    <?php } ?>

                    <!--Manager menu-->
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['privilege'] >= 2) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center <?php echo in_array($current_page, ['edit-items.php', 'categories.php', 'order-history.php', 'users.php']) ? 'active' : ''; ?>" 
                                href="<?php echo $urlPrefix ?>/admin/links.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">manage_accounts</span>
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item d-flex align-items-center<?php echo $current_page == 'edit-items.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/admin/edit-items.php">
                                    <span class="material-symbols-outlined">edit</span>
                                    Edit items
                                </a></li>
                                <li><a class="dropdown-item d-flex align-items-center<?php echo $current_page == 'categories.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/admin/categories.php">
                                    <span class="material-symbols-outlined">edit</span>
                                    Edit categories
                                </a></li>
                                <li><a class="dropdown-item d-flex align-items-center<?php echo $current_page == 'order-history.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/admin/order-history.php">
                                    <span class="material-symbols-outlined">overview</span>  
                                    Order History
                                </a></li>
                                <li><a class="dropdown-item d-flex align-items-center<?php echo $current_page == 'users.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/admin/users.php">
                                    <span class="material-symbols-outlined">manage_accounts</span>  
                                    Users
                                </a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <!--Account-->
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item <?php echo $current_page == 'account.php' ? 'active' : ''; ?>">
                            <a class="nav-link d-flex align-items-center" href="<?php echo $urlPrefix ?>/account.php">
                                <span class="material-symbols-outlined">account_circle</span>
                                <?php echo $_SESSION['user']['name'] ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!--Login/Logout-->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center <?php echo $current_page == 'login.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user']) ? $urlPrefix."/logout.php" : $urlPrefix."/login.php" ?>">
                            <span class="material-symbols-outlined"><?php echo isset($_SESSION['user']) ? "logout" : "login" ?></span>
                            <?php echo isset($_SESSION['user']) ? "Logout" : "Login" ?>
                        </a>
                    </li>

                    <!--Register-->
                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'register.php' ? 'active' : ''; ?>" href="<?php echo $urlPrefix ?>/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>