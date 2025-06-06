<?php @session_start();
require_once __DIR__ . '\../database/AnimalsDB.php';

$current_page = basename($_SERVER['PHP_SELF']);
$AnimalsDB = new AnimalsDB();

$Animals = $AnimalsDB->fetch(null);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Caw</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="icons/cat.png" />
    <link href="/dlam01/sp/css/styles.css" rel="stylesheet" />
</head>

<body>
    <div id="holder">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-teal">
            <div class="container">
                <a class="navbar-brand" href="/dlam01/sp/index.php">My pet store</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav al-left">
                        <?php foreach ($Animals as $animal): ?>
                            <li class="nav-item <?= (isset($_GET['animal_id']) && $_GET['animal_id'] == $animal['id']) ? 'active' : '' ?>">
                                <a class="nav-link" href="/dlam01/sp/animal.php?animal_id=<?= $animal['id']; ?>"><?= htmlspecialchars($animal['name']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?= $current_page == 'index.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/index.php">Home</a></li>
                        <li class="nav-item <?= $current_page == 'cart.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/cart.php">Cart</a></li>
                        <?php if (empty($_SESSION["email"])): ?>
                            <li class="nav-item <?php echo $current_page == 'login.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/login.php">Login</a></li>
                            <li class="nav-item <?php echo $current_page == 'register.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/register.php">Register</a></li>
                        <?php else: ?>
                            <?php if ($_SESSION["privilege"] > 1): ?>
                                <li class="nav-item <?php echo $current_page == 'adminProducts.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/administration/adminProducts.php">Administration</a></li>
                            <?php endif; ?>
                            <li class="nav-item <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/profile-information.php">Profile</a></li>
                            <li class="nav-item <?php echo $current_page == 'logout.php' ? 'active' : ''; ?>"><a class="nav-link" href="/dlam01/sp/logout.php">Sign out</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="body">