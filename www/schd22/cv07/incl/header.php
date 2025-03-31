
<?php 
require_once __DIR__ . '/../database/ProductDB.php';
$productsDB = new ProductDB();
$numberOfProducts = $productsDB->countProducts();
?>

<?php
$isLoggedIn = isset($_COOKIE['name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <link href="../CV07/css/style.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Vendor currently has <?php echo $numberOfProducts?> items</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="create-item.php">Create Item</a></li>
                        <?php if ($isLoggedIn): ?>
                             <li class="nav-item"><a class="nav-link" href="cart.php">Cart </a></li>
                             <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo htmlspecialchars($_COOKIE['name']); ?>)</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                         <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>