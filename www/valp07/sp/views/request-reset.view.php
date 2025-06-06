<?php require __DIR__ . '/../incl/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Request Password Reset</h4>

            <?php if (!empty($resetLink)): ?>
                <div class="alert alert-success text-break">
                    Reset link generated
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your email address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../incl/footer.php'; ?>