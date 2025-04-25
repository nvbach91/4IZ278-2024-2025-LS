<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "head.php";
?>
<!-- Page Content-->
<div class="container">
    <div class="row">


        <div class="col-lg-9">
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