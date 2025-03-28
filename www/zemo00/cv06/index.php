<?php

include __DIR__ . "/includes/head.html";

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;


?>

<div class="container">
    <div class="row">
        <?php require __DIR__ . "/components/CategoryDisplay.php" ?>
        <div class="col-lg-9">
            <?php require __DIR__ . "/components/SlideDisplay.php" ?>
            <div class="row">
                <?php require __DIR__ . "/components/ProductDisplay.php" ?>
            </div>
        </div>
    </div>
</div>

<?php

include __DIR__ . "/includes/foot.html";

?>