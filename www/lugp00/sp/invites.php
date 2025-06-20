<?php
// sp/invites.php

$pageTitle = 'Pozvánky';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/TaskShare.php';

use App\DatabaseConnection;
use App\Auth;
use App\TaskShare;

$pdo        = DatabaseConnection::getPDOConnection();
$auth       = new Auth($pdo);
$shareModel = new TaskShare($pdo);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId  = $_SESSION['user_id'];
$errors  = [];
$success = [];

// Přijetí / odmítnutí
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action  = $_POST['action']     ?? '';
    $shareId = (int)($_POST['share_id'] ?? 0);

    if ($action === 'accept') {
        if ($shareModel->accept($shareId)) {
            $success[] = 'Pozvánka přijata.';
        } else {
            $errors[] = 'Nepodařilo se přijmout pozvánku.';
        }
    }

    if ($action === 'decline') {
        if ($shareModel->decline($shareId)) {
            $success[] = 'Pozvánka odmítnuta.';
        } else {
            $errors[] = 'Nepodařilo se odmítnout pozvánku.';
        }
    }
}

// Načtení nevyřízených pozvánek
$invites = $shareModel->getPendingForUser($userId);
?>
<h3 class="mb-4">Pozvánky k úkolům</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger"><ul class="mb-0">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><ul class="mb-0">
    <?php foreach ($success as $m): ?><li><?= htmlspecialchars($m) ?></li><?php endforeach; ?>
  </ul></div>
<?php endif; ?>

<?php if (empty($invites)): ?>
  <p class="text-muted">Žádné nové pozvánky.</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($invites as $inv): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= htmlspecialchars($inv['title']) ?></strong><br>
          od <?= htmlspecialchars($inv['shared_by_name']) ?>
          (<?= htmlspecialchars($inv['shared_by_email']) ?>)
        </div>
        <div class="btn-group">
          <form method="post">
            <input type="hidden" name="action" value="accept">
            <input type="hidden" name="share_id" value="<?= $inv['share_id'] ?>">
            <button type="submit" class="btn btn-sm btn-success">Přijmout</button>
          </form>
          <form method="post">
            <input type="hidden" name="action" value="decline">
            <input type="hidden" name="share_id" value="<?= $inv['share_id'] ?>">
            <button type="submit" class="btn btn-sm btn-danger">Odmítnout</button>
          </form>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
