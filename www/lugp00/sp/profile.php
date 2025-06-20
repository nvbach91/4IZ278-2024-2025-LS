<?php
// sp/profile.php

$pageTitle = 'Profil';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/User.php';

use App\DatabaseConnection;
use App\Auth;
use App\User;

$auth      = new Auth(DatabaseConnection::getPDOConnection());
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId    = $_SESSION['user_id'];
$userName  = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
$userModel = new User(DatabaseConnection::getPDOConnection());

$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password']       ?? '';
    $newPassword     = $_POST['new_password']           ?? '';
    $newPassword2    = $_POST['new_password_confirm']   ?? '';

    // update password
    if ($newPassword || $newPassword2) {
        if ($newPassword === '' || $newPassword !== $newPassword2) {
            $errors[] = 'Nová hesla se neshodují.';
        } elseif (!$userModel->verifyPassword($userId, $currentPassword)) {
            $errors[] = 'Špatné heslo.';
        } elseif ($userModel->updatePassword($userId, $newPassword)) {
            $success = 'Heslo bylo úspěšně změněno.';
        } else {
            $errors[] = 'Aktualizace hesla selhala.';
        }
    }
}
?>
<h3 class="mb-4">Správa profilu</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger"><ul class="mb-0">
    <?php foreach ($errors as $e): ?>
      <li><?= htmlspecialchars($e) ?></li>
    <?php endforeach; ?>
  </ul></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" novalidate>
  <div class="mb-3">
    <label class="form-label">E-mail</label>
    <input
      type="email"
      class="form-control-plaintext"
      readonly
      value="<?= htmlspecialchars($userEmail) ?>"
    >
  </div>

  <div class="mb-3">
    <label class="form-label">Současné heslo</label>
    <input
      type="password"
      name="current_password"
      class="form-control"
      placeholder="Potvrďte změnu hesla"
      required
    >
  </div>

  <div class="mb-3">
    <label class="form-label">Nové heslo</label>
    <input
      type="password"
      name="new_password"
      class="form-control"
      placeholder="(volitelné)"
    >
  </div>

  <div class="mb-4">
    <label class="form-label">Nové heslo znovu</label>
    <input
      type="password"
      name="new_password_confirm"
      class="form-control"
      placeholder="(volitelné)"
    >
  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Uložit změny</button>
    <a href="dashboard.php" class="btn btn-secondary">Zpět na dashboard</a>
  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
