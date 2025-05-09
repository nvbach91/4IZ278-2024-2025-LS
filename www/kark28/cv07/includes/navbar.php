<!-- Navigation-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'index') || preg_match('/\/$/', $_SERVER['REQUEST_URI']) ? ' active' : '' ?>">
                            <a class="nav-link" href="index.php">Home</a></li>
                        
                        <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'cart') ? ' active' : '' ?>"><a class="nav-link" href="cart.php">Cart</a></li>
                        
                        <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'profile') ? ' active' : '' ?>"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i> <?php echo @$_COOKIE['name']; ?> </a></li>
                        <li class="nav-item"><a class="nav-link" href="./utils/logout.php">| Logout</a></li>

                         <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>