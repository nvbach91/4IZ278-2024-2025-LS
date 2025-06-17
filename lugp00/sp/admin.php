<?php
// sp/admin.php

$pageTitle = 'Admin – Správa uživatelů';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/User.php';
require_once __DIR__ . '/database/Task.php';

use App\DatabaseConnection;
use App\Auth;
use App\User;
use App\Task;

$pdo       = DatabaseConnection::getPDOConnection();
$auth      = new Auth($pdo);
$userModel = new User($pdo);
$taskModel = new Task($pdo);

// Ochrana: pouze admin může
if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
    header('Location: login.php');
    exit;
}

$errors  = '';
$success = '';

// Zpracování smazání uživatele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $delId = (int)$_POST['delete_user_id'];
    if ($userModel->deleteUser($delId)) {
        $success = 'Uživatel byl smazán.';
    } else {
        $errors = 'Chyba při mazání uživatele.';
    }
}

// Načtení všech uživatelů
$users = $userModel->getAllUsers();
?>
<h3 class="mb-4">Správa uživatelů</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($errors) ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Jméno</th>
      <th>E-mail</th>
      <th class="text-center">Úkolů</th>
      <th>Registrace</th>
      <th class="text-end">Akce</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td class="text-center">
          <?php
            $stmtCount = $pdo->prepare('SELECT COUNT(*) FROM tasks WHERE user_id = :uid');
            $stmtCount->execute(['uid' => $u['id']]);
            echo $stmtCount->fetchColumn();
          ?>
        </td>
        <td><?= date('j.n.Y H:i', strtotime($u['created_at'])) ?></td>
        <td class="text-end">
          <?php if ($u['id'] !== $_SESSION['user_id']): ?>
            <form method="post" onsubmit="return confirm('Opravdu smazat uživatele <?= htmlspecialchars($u['email']) ?>?');">
              <input type="hidden" name="delete_user_id" value="<?= $u['id'] ?>">
              <button class="btn btn-danger btn-sm">Smazat</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
