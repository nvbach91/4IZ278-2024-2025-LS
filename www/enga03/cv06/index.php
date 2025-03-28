<?php
/*
 * @author: Amelie Engelmaierová 
 */
?>

<?php include_once "./includes/Header.php"?>
        <!-- Page Content-->
        <div class="container">
            <div class="row">
                <!-- Categories -->
                <?php include_once "./components/CategoryDisplay.php"?>
                <div class="col-lg-9">
                    <!-- Carousel -->
                    <?php include_once "./components/CarouselDisplay.php"?>
                    <!-- Products-->
                    <?php require "./components/ProductDisplay.php"?>
                </div>
            </div>
        </div>
<?php include_once "./includes/Footer.php"?>