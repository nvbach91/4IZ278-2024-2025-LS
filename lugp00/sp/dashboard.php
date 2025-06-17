<?php
// sp/dashboard.php

$pageTitle = 'Dashboard';
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

$pdo        = DatabaseConnection::getPDOConnection();
$auth       = new Auth($pdo);
$taskModel  = new Task($pdo);
$tagModel   = new Tag($pdo);
$shareModel = new TaskShare($pdo);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// 1) vlastní úkoly
$ownUnassigned = $taskModel->getByStatus($userId, 'unclaimed');
$ownClaimed    = $taskModel->getByStatus($userId, 'claimed');
$ownFinished   = $taskModel->getByStatus($userId, 'finished');

// označíme vlastní úkoly
foreach ($ownUnassigned as &$t) { $t['shared'] = false; } unset($t);
foreach ($ownClaimed    as &$t) { $t['shared'] = false; } unset($t);
foreach ($ownFinished   as &$t) { $t['shared'] = false; } unset($t);

// 2) sdílené (přijaté) úkoly
function getSharedByStatus(PDO $pdo, int $userId, string $status): array {
    $stmt = $pdo->prepare(
        'SELECT t.id, t.title, t.description, t.status
         FROM tasks t
         JOIN task_shares ts ON t.id = ts.task_id
         WHERE ts.shared_with_user_id = :uid
           AND ts.status = \'accepted\'
           AND t.status = :status
         ORDER BY t.created_at DESC'
    );
    $stmt->execute(['uid' => $userId, 'status' => $status]);
    return $stmt->fetchAll();
}

$sharedUnassigned = getSharedByStatus($pdo, $userId, 'unclaimed');
$sharedClaimed    = getSharedByStatus($pdo, $userId, 'claimed');
$sharedFinished   = getSharedByStatus($pdo, $userId, 'finished');

// označíme sdílené úkoly
foreach ($sharedUnassigned as &$t) { $t['shared'] = true; } unset($t);
foreach ($sharedClaimed    as &$t) { $t['shared'] = true; } unset($t);
foreach ($sharedFinished   as &$t) { $t['shared'] = true; } unset($t);

// 3) sloučíme obě skupiny
$unassigned = array_merge($ownUnassigned, $sharedUnassigned);
$claimed    = array_merge($ownClaimed,    $sharedClaimed);
$finished   = array_merge($ownFinished,   $sharedFinished);
?>
<div class="row">
  <?php foreach ([
    'Nepřiřazené' => $unassigned,
    'Rozdělané'   => $claimed,
    'Dokončené'   => $finished
  ] as $heading => $tasks): ?>
    <div class="col-md-4 mb-4">
      <h4 class="text-center mb-3"><?= htmlspecialchars($heading) ?></h4>
      <?php if (empty($tasks)): ?>
        <p class="text-muted text-center">Žádné úkoly</p>
      <?php else: foreach ($tasks as $task): ?>
        <div class="card mb-3 shadow-sm <?= $task['shared'] ? 'border-info' : '' ?>">
          <div class="card-body">
            <h5 class="card-title">
              <?= htmlspecialchars($task['title']) ?>
              <?php if ($task['shared']): ?>
                <span class="badge bg-info ms-2">Sdílené</span>
              <?php endif; ?>
            </h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($task['description'] ?? '')) ?></p>
            <?php
              $tags = $tagModel->getByTask($task['id']);
              if ($tags):
            ?>
              <div class="mt-2">
                <?php foreach ($tags as $tag): ?>
                  <span
                    class="badge"
                    style="background-color: <?= htmlspecialchars($tag['color']) ?>; color:#fff; margin-right:4px;"
                  >
                    <?= htmlspecialchars($tag['name']) ?>
                  </span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <a href="edit_task.php?id=<?= $task['id'] ?>" class="stretched-link"></a>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
