<?php
// sp/archived.php

$pageTitle = 'Archiv dokončených úkolů';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/Task.php';
require_once __DIR__ . '/database/Tag.php';
require_once __DIR__ . '/database/TaskShare.php';

use App\DatabaseConnection;
use App\Auth;
use App\Task;
use App\Tag;
use App\TaskShare;

$pdo = DatabaseConnection::getPDOConnection();
$auth = new Auth($pdo);
$taskModel = new Task($pdo);
$tagModel = new Tag($pdo);
$shareModel = new TaskShare($pdo);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// Načtení vlastní dokončených úkoů včetně updated_at
$stmtOwn = $pdo->prepare(
    'SELECT id, title, description, created_at, updated_at
     FROM tasks
     WHERE user_id = :uid AND status = \'finished\'
     ORDER BY updated_at DESC'
);
$stmtOwn->execute(['uid' => $userId]);
$ownFinished = $stmtOwn->fetchAll();

// Načíst sdílené dokončené úkoly
$stmtShared = $pdo->prepare(
    'SELECT t.id, t.title, t.description, t.created_at, t.updated_at
     FROM tasks t
     JOIN task_shares ts ON t.id = ts.task_id
     WHERE ts.shared_with_user_id = :uid
       AND ts.status = \'accepted\'
       AND t.status = \'finished\'
     ORDER BY t.updated_at DESC'
);
$stmtShared->execute(['uid' => $userId]);
$sharedFinished = $stmtShared->fetchAll();

// Sloučení vlastních a sdílených úkolů
foreach ($ownFinished as &$t)    { $t['shared'] = false; } unset($t);
foreach ($sharedFinished as &$t) { $t['shared'] = true;  } unset($t);
$allFinished = array_merge($ownFinished, $sharedFinished);

// Seřadit podle updated_at DESC
usort($allFinished, function($a, $b) {
    return strtotime($b['updated_at']) - strtotime($a['updated_at']);
});

// Vytáhnout archiv (vše kromě 5 nejnovějších)
$archive = array_slice($allFinished, 5);
?>
<div class="container py-4">
  <h3 class="mb-4">Archiv dokončených úkolů - starších než 5</h3>

  <?php if (empty($archive)): ?>
    <p class="text-muted">Žádné archivované úkoly.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($archive as $task): ?>
        <div class="col-md-6 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">
                <?= htmlspecialchars($task['title']) ?>
                <?php if ($task['shared']): ?>
                  <span class="badge bg-info ms-2">Sdílené</span>
                <?php endif; ?>
              </h5>
              <p class="text-muted mb-2" style="font-size:.875em;">
                Dokončeno: <?= date('j.n.Y H:i', strtotime($task['updated_at'])) ?>
              </p>
              <p class="card-text"><?= nl2br(htmlspecialchars($task['description'] ?? '')) ?></p>
              <?php
                $tags = $tagModel->getByTask($task['id']);
                if ($tags):
              ?>
                <div class="mt-2">
                  <?php foreach ($tags as $tag): ?>
                    <span
                      class="badge"
                      style="background-color: <?= htmlspecialchars($tag['color']) ?>; color: #fff; margin-right:4px;"
                    >
                      <?= htmlspecialchars($tag['name']) ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
