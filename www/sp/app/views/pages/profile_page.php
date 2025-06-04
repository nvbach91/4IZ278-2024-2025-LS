<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5 text-center">
    <h3 class="mb-2"><?php echo htmlspecialchars($user['email']); ?></h3>
    <p class="mb-4 text-muted">Since <?php echo $user['created_at']; ?></p>

    <div class="d-flex justify-content-center gap-3">
        <a href="<?php echo BASE_URL . "/change_password"; ?>" class="btn btn-outline-primary">Change password</a>
        <a href="<?php echo BASE_URL . "/logout"; ?>" class="btn btn-danger">Log out</a>
    </div>
</div>

<?php

include __DIR__ . "/../partials/foot.html";

?>