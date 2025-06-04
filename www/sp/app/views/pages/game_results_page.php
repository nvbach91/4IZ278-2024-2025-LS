<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5">
    <h1 class="mb-4">Game results</h1>

    <?php require __DIR__ . "/../tables/game_results_table.php"; ?>

    <a href="<?php echo BASE_URL . "/home"; ?>" class="btn btn-primary mt-4">Finish</a>
</div>

<?php include __DIR__ . "/../partials/foot.html"; ?>