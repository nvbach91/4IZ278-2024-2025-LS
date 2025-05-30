<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?php echo SITE_URL; ?>">Ticketing System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">Home</a>
                        </li>
                        <?php if (isLoggedIn()): ?>
                            <?php
                            $cartCount = isset($_SESSION['reserved_seats']) ? count($_SESSION['reserved_seats']) : 0;
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>cart.php">
                                    <i class="fa fa-shopping-cart"></i> Cart
                                    <?php if ($cartCount > 0): ?>
                                        <span class="badge badge-pill badge-danger"><?php echo $cartCount; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>orders.php">My Orders</a>
                            </li>
                        <?php endif; ?>
                        <?php if (isAdmin()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs"></i> Admin
                                </a>
                                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/dashboard.php">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/events.php">
                                        <i class="fas fa-calendar-alt mr-2"></i> Manage Events
                                    </a>
                                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/event_types.php">
                                        <i class="fas fa-list mr-2"></i> Event Types
                                    </a>
                                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/seat_categories.php">
                                        <i class="fas fa-chair mr-2"></i> Seat Categories
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (isLoggedIn()): ?>
                            <li class="nav-item">
                                <span class="nav-link">Hello, <?php echo escape($_SESSION['user_name']); ?></span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>