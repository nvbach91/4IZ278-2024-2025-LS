<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/php/loginHelpers.php';
$error = handleLogin();
?>
<?php require_once __DIR__ . '/layouts/head.php'; ?>

<div class="auth-card">
    <h3 class="text-center mb-4 fw-bold">Přihlášení</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="fw-bold">Email</label>
            <input class="form-control" type="email" name="email" required autofocus>
        </div>
        <div class="mb-4">
            <label class="fw-bold">Heslo</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Přihlásit</button>
    </form>
    <div class="text-center mt-3">
        <span>Nemáte účet?</span> <a href="register.php">Registrace zde</a>
    </div>
</div>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
