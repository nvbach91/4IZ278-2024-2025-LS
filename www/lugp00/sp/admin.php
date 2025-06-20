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

// Ochrana: pouze admin
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

// Celková statistika úkolů
$totalsStmt = $pdo->query("
    SELECT
      SUM(status = 'unclaimed') AS unassigned,
      SUM(status = 'claimed')   AS claimed,
      SUM(status = 'finished')  AS finished
    FROM tasks
");
$totals = $totalsStmt->fetch();

// Připravený dotaz pro rozpad počtů úkolů včetně sdílených
$countsStmt = $pdo->prepare("
    SELECT
      (SELECT COUNT(*) FROM tasks WHERE user_id = :uid AND status = 'unclaimed')
      +
      (SELECT COUNT(*) 
         FROM task_shares ts 
         JOIN tasks t ON t.id = ts.task_id
         WHERE ts.shared_with_user_id = :uid
           AND ts.status = 'accepted'
           AND t.status = 'unclaimed'
      ) AS unassigned,
      (SELECT COUNT(*) FROM tasks WHERE user_id = :uid AND status = 'claimed')
      +
      (SELECT COUNT(*) 
         FROM task_shares ts 
         JOIN tasks t ON t.id = ts.task_id
         WHERE ts.shared_with_user_id = :uid
           AND ts.status = 'accepted'
           AND t.status = 'claimed'
      ) AS claimed,
      (SELECT COUNT(*) FROM tasks WHERE user_id = :uid AND status = 'finished')
      +
      (SELECT COUNT(*) 
         FROM task_shares ts 
         JOIN tasks t ON t.id = ts.task_id
         WHERE ts.shared_with_user_id = :uid
           AND ts.status = 'accepted'
           AND t.status = 'finished'
      ) AS finished
");
?>
<h3 class="mb-4">Správa uživatelů</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($errors) ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="alert alert-secondary">
  <strong>Celkově úkolů:</strong>
  Nepřiřazené: <?= (int)$totals['unassigned'] ?>,
  Rozdělané: <?= (int)$totals['claimed'] ?>,
  Dokončené: <?= (int)$totals['finished'] ?>
</div>

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Jméno</th>
      <th>E-mail</th>
      <th class="text-center">Nepřiřazené</th>
      <th class="text-center">Rozdělané</th>
      <th class="text-center">Dokončené</th>
      <th>Registrace</th>
      <th class="text-end">Akce</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <?php
        $countsStmt->execute(['uid' => $u['id']]);
        $c = $countsStmt->fetch();
      ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td class="text-center"><?= (int)$c['unassigned'] ?></td>
        <td class="text-center"><?= (int)$c['claimed'] ?></td>
        <td class="text-center"><?= (int)$c['finished'] ?></td>
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
