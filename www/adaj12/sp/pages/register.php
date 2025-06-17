<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/php/registerHelpers.php';
list($error, $success) = handleRegistration();
?>
<?php require_once __DIR__ . '/layouts/head.php'; ?>

<div class="auth-card">
    <h3 class="text-center mb-4 fw-bold">Registrace</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="fw-bold">Přezdívka</label>
            <input class="form-control" type="text" name="name" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Email</label>
            <input class="form-control" type="email" name="email" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Heslo</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <div class="mb-4">
            <label class="fw-bold">Heslo znovu</label>
            <input class="form-control" type="password" name="password2" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Registrovat</button>
    </form>
    <div class="text-center mt-3">
        <span>Máte už účet?</span> <a href="/~adaj12/test/pages/login.php">Přihlášení zde</a>
    </div>
</div>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
