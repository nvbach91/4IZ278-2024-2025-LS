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
                    <?php if (!isset($_COOKIE["name"])): ?>
                        <li class="nav-item active"><a class="nav-link" href=".">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                    <?php endif; ?>

                    <?php if (isset($_COOKIE["name"])): ?>
                        <li class="nav-item active"><a class="nav-link" href=".">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./cart.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="./profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="./logout.php">Sign out</li></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="body">