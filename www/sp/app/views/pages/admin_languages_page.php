<?php
require __DIR__ . "/../partials/head_admin.php";
?>

<div class="container my-4">
    <a href="<?php echo BASE_URL . "/admin/add_language"; ?>" class="btn btn-success mb-3">Add language</a>

    <?php require __DIR__ . "/../tables/languages_table.php"; ?>
</div>

<?php include __DIR__ . "/../partials/foot.html"; ?>