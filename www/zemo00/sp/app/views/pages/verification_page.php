<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5">
    <?php if ($result == 'success'): ?>
        <div class="alert alert-success text-center">
            <h2 class="mb-3">Success!</h2>
            <a href="<?php echo BASE_URL . "/login"; ?>" class="btn btn-primary">Login</a>
        </div>
    <?php elseif ($result == 'expired'): ?>
        <div class="alert alert-warning text-center">
            <h2 class="mb-3">Verification token expired</h2>
            <form action="<?php echo BASE_URL . "/refresh_token"; ?>" method="POST">
                <input type="hidden" value="<?php echo $user['email']; ?>" name="email">
                <button type="submit" class="btn btn-warning">Refresh token</button>
            </form>
        </div>
    <?php elseif ($result == 'no-token'): ?>
        <div class="alert alert-danger text-center">
            <h2>No or invalid verification token provided</h2>
        </div>
    <?php elseif ($result == null): ?>
        <h2>Click the button to verify:</h2>
        <form action="<?php echo BASE_URL . "/verify"; ?>" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button type="submit">Verify</button>
        </form>
    <?php endif; ?>
</div>

<?php

include __DIR__ . "/../partials/foot.html";

?>