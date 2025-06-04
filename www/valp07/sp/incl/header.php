<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shop Homepage - Start Bootstrap Template</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">

    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="https://eso.vse.cz/~valp07/sp/">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">

                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <li class="nav-item"><a class="nav-link" href="https://eso.vse.cz/~valp07/sp/cart.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://eso.vse.cz/~valp07/sp/profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://eso.vse.cz/~valp07/sp/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="https://eso.vse.cz/~valp07/sp/registration.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://eso.vse.cz/~valp07/sp/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>