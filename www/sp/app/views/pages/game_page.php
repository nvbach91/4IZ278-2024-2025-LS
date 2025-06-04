<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5" id="game-container">
    <div id="progress" class="mb-3 fw-bold">1 / <?php echo $amount; ?></div>

    <div id="question" class="text-center">
        <h2 id="word-display" class="mb-4"></h2>

        <div id="options-container" class="d-grid gap-3 mb-4" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
            <button class="option-button btn btn-outline-primary"></button>
            <button class="option-button btn btn-outline-primary"></button>
            <button class="option-button btn btn-outline-primary"></button>
            <button class="option-button btn btn-outline-primary"></button>
        </div>

        <button id="next" class="btn btn-primary mb-3" disabled>Next</button>

        <form action="<?php echo BASE_URL . "/game_results"; ?>" method="POST" id="finish-form" style="display: none;">
            <input type="hidden" name="total" value="<?php echo $amount; ?>">
            <input type="hidden" name="results" id="results-input">
            <button type="submit" id="finish" class="btn btn-success">Finish</button>
        </form>
    </div>
</div>

<script>
    const gameWords = <?php echo json_encode($gameWords); ?>;
</script>
<script src="<?php echo BASE_URL . "/public/js/game.js"; ?>"></script>

<?php

include __DIR__ . "/../partials/foot.html";

?>