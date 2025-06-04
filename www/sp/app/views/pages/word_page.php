<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5">
    <h4 class="mb-4"><?php echo htmlspecialchars($word['icon']) . htmlspecialchars($word['word']); ?></h4>

    <?php require __DIR__ . "/../tables/word_concepts_table.php"; ?>
</div>

<?php

include __DIR__ . "/../partials/foot.html";

?>