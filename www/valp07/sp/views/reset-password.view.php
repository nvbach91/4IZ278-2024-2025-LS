<?php require __DIR__ . '/../incl/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <?php if ($error): ?>
                <h4 class="card-title text-center text-danger">Password Reset Failed</h4>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($newPassword): ?>
                <h4 class="card-title text-center text-success">Password Reset Successful</h4>
                <p class="card-text text-center">Your new password is:</p>
                <div class="alert alert-info text-center" style="font-size: 1.2em; font-weight: bold;">
                    <?php echo htmlspecialchars($newPassword); ?>
                </div>
                <p class="text-muted text-center">Please copy this password and log in. You can change it later in your profile.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../incl/footer.php'; ?>