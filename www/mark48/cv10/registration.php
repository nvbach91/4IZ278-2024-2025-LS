<?php
// registration.php

require_once 'db/DbPdo.php';
require_once 'db/UserDb.php';
require_once 'head.php';

$error = '';
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Základní validace
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'Vyplňte všechny údaje.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Neplatný formát emailu.';
    } elseif ($password !== $confirm) {
        $error = 'Hesla se neshodují.';
    } else {
        $db  = Database::getInstance()->getConnection();
        $udb = new UserDb($db);
        if ($udb->createUser($name, $email, $password)) {
            header('Location: login.php');
            exit;
        } else {
            $error = 'Email je již registrován.';
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Registrace</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Jméno</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required
                value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Heslo</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Potvrďte heslo</label>
            <input
                type="password"
                class="form-control"
                id="confirm_password"
                name="confirm_password"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Registrovat</button>
        <a href="login.php" class="btn btn-link">Přihlásit se</a>
    </form>
</div>

<?php require 'footer.php'; ?>