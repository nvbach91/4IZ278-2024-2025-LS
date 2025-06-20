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

// rychlá změna stavu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status') {
    $taskId    = (int)($_POST['task_id'] ?? 0);
    $newStatus = $_POST['status'] ?? '';
    if ($taskId && in_array($newStatus, ['unclaimed','claimed','finished'], true)) {
        $taskModel->updateStatus($taskId, $newStatus);
    }
    header('Location: dashboard.php');
    exit;
}

/**
 * Načte vlastní úkoly s daným statusem včetně created_at a updated_at.
 */
function getOwnByStatus(PDO $pdo, int $userId, string $status): array {
    $stmt = $pdo->prepare(
        'SELECT id, title, description, status, created_at, updated_at
         FROM tasks
         WHERE user_id = :uid AND status = :status'
    );
    $stmt->execute(['uid' => $userId, 'status' => $status]);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) { $r['shared'] = false; } unset($r);
    return $rows;
}

/**
 * Načte sdílené úkoly s daným statusem včetně created_at a updated_at.
 */
function getSharedByStatus(PDO $pdo, int $userId, string $status): array {
    $stmt = $pdo->prepare(
        'SELECT t.id, t.title, t.description, t.status, t.created_at, t.updated_at
         FROM tasks t
         JOIN task_shares ts ON t.id = ts.task_id
         WHERE ts.shared_with_user_id = :uid
           AND ts.status = \'accepted\'
           AND t.status = :status'
    );
    $stmt->execute(['uid' => $userId, 'status' => $status]);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) { $r['shared'] = true; } unset($r);
    return $rows;
}

// načítáme nepřiřazené a rozdělané
$unassigned = array_merge(
    getOwnByStatus($pdo, $userId, 'unclaimed'),
    getSharedByStatus($pdo, $userId, 'unclaimed')
);
$claimed = array_merge(
    getOwnByStatus($pdo, $userId, 'claimed'),
    getSharedByStatus($pdo, $userId, 'claimed')
);

// dokončené – pouze posledních 5 podle updated_at
$finishedAll = array_merge(
    getOwnByStatus($pdo, $userId, 'finished'),
    getSharedByStatus($pdo, $userId, 'finished')
);
usort($finishedAll, fn($a, $b) => strtotime($b['updated_at']) - strtotime($a['updated_at']));
$finished = array_slice($finishedAll, 0, 5);
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
          <div class="card-body position-relative">
            <a href="edit_task.php?id=<?= $task['id'] ?>" class="stretched-link"></a>

            <h5 class="card-title">
              <?= htmlspecialchars($task['title']) ?>
              <?php if ($task['shared']): ?>
                <span class="badge bg-info ms-2">Sdílené</span>
              <?php endif; ?>
            </h5>

            <p class="text-muted mb-1" style="font-size:.875em;">
              Vytvořeno: <?= date('j.n.Y H:i', strtotime($task['created_at'])) ?>
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
                    style="background-color: <?= htmlspecialchars($tag['color']) ?>; color:#fff; margin-right:4px;"
                  >
                    <?= htmlspecialchars($tag['name']) ?>
                  </span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div style="position: relative; z-index: 2;" class="mt-3">
              <form method="post">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                <select
                  name="status"
                  class="form-select form-select-sm"
                  onchange="this.form.submit()"
                >
                  <option value="unclaimed" <?= $task['status'] === 'unclaimed' ? 'selected' : '' ?>>Nepřiřazené</option>
                  <option value="claimed"   <?= $task['status'] === 'claimed'   ? 'selected' : '' ?>>Rozdělané</option>
                  <option value="finished"  <?= $task['status'] === 'finished'  ? 'selected' : '' ?>>Dokončené</option>
                </select>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
