<?php
require_once 'db/DbPdo.php';
require_once 'db/UserDb.php';
require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Vyplňte prosím email i heslo.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Zadejte platný formát emailu.';
    } else {
        $db = Database::getInstance()->getConnection();
        $udb = new UserDb($db);
        $user = $udb->getUserByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            // přihlášení uživatele
            loginUser($user);
            header('Location: index.php');
            exit;
        } else {
            $error = 'Nesprávný email nebo heslo.';
        }
    }
}



require 'head.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Přihlášení</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Přihlásit se</button>
        <a href="registration.php" class="btn btn-link">Registrovat se</a>
    </form>
</div>

<?php
require 'footer.php';
?>