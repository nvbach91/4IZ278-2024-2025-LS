<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5">
    <h3 class="mb-4"><?php echo htmlspecialchars($collection['name']); ?></h3>
    <a href="<?php echo BASE_URL . "/delete_collection?collectionId=" . urlencode($collection['collection_id']); ?>" class="btn btn-danger mb-3">Delete</a>

    <?php require __DIR__ . "/../tables/words_table.php"; ?>
</div>

<?php include __DIR__ . "/../partials/foot.html"; ?>