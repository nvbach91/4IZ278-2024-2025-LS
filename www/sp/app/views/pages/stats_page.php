<?php require __DIR__ . "/../partials/head.php"; ?>

<div class="container my-5">
    <h1 class="mb-4">Game results</h1>

    <table class="table table-bordered w-auto">
        <tr>
            <td><strong>Games played:</strong></td>
            <td><?php echo $stats['games_played'] ?? 0; ?></td>
        </tr>
        <tr>
            <td><strong>Correct words:</strong></td>
            <td><?php echo $stats['correct'] ?? 0; ?></td>
        </tr>
        <tr>
            <td><strong>Incorrect words:</strong></td>
            <td><?php echo $stats['incorrect'] ?? 0; ?></td>
        </tr>
        <tr>
            <td><strong>Success rate:</strong></td>
            <td><?php echo $stats['success_rate'] ?? 0; ?>%</td>
        </tr>
    </table>

    <a href="<?php echo BASE_URL . "/home"; ?>" class="btn btn-secondary mt-3">Back to Home</a>
</div>

<?php include __DIR__ . "/../partials/foot.html"; ?>