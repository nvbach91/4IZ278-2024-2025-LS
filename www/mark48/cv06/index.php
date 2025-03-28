<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "head.php";
?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#!">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#!">
                        Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Page Content-->
<div class="container">
    <div class="row">
        <?php
        require "CategoryDisplay.php";
        ?>

        <div class="col-lg-9">

            <?php
            require "CarouselDisplay.php";
            ?>

            <div class="row">
                <?php
                require "ProductDisplay.php";
                ?>
            </div>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>