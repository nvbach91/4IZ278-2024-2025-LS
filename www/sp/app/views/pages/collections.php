<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5">
    <a href="<?php echo BASE_URL . "/create_collection"; ?>" class="btn btn-success mb-4">Create a collection</a>

    <?php require __DIR__ . "/../tables/collections_table.php"; ?>
</div>

<?php include __DIR__ . "/../partials/foot.html"; ?>