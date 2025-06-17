<?php
// sp/edit_task.php

$pageTitle = 'Úprava úkolu';
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

$taskId = (int)($_GET['id'] ?? 0);
if (!$taskId) {
    header('Location: dashboard.php');
    exit;
}

// Načtení úkolu + práv
$stmt = $pdo->prepare(
    'SELECT t.*,
            t.user_id = :uid AS is_owner,
            EXISTS(
              SELECT 1 FROM task_shares ts
              WHERE ts.task_id = t.id
                AND ts.shared_with_user_id = :uid
                AND ts.status = \'accepted\'
            ) AS is_shared
     FROM tasks t
     WHERE t.id = :id'
);
$stmt->execute(['id' => $taskId, 'uid' => $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task || (! $task['is_owner'] && ! $task['is_shared'])) {
    header('Location: dashboard.php');
    exit;
}

$isOwner      = (bool)$task['is_owner'];
$isSharedUser = ! $isOwner && (bool)$task['is_shared'];

// Pro form: tagy vlastníka úkolu
$taskOwnerId = (int)$task['user_id'];
$allTags     = $tagModel->getAll($taskOwnerId);

$title        = $task['title'];
$description  = $task['description'];
$status       = $task['status'];
$createdAt    = $task['created_at'];
$updatedAt    = $task['updated_at'];

$existingTags = $tagModel->getByTask($taskId);
$selectedTags = array_column($existingTags, 'id');

$errors  = [];
$success = [];
$sharedUsers = $shareModel->getSharedUsers($taskId);

// POST zpracování
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1) Odebrat vlastní přístup (sdílený uživatel)
    if ($action === 'unshare_self' && $isSharedUser) {
        $shareModel->unshare($taskId, $_SESSION['user_id']);
        header('Location: dashboard.php');
        exit;
    }

    // 2) Smazat úkol (vlastník)
    if ($action === 'delete' && $isOwner) {
        $taskModel->delete($taskId);
        header('Location: dashboard.php');
        exit;
    }

    // 3) Uložit změny (vlastník i sdílený uživatel)
    if ($action === 'save') {
        $newTitle       = trim($_POST['title']       ?? '');
        $newDescription = trim($_POST['description'] ?? '');
        $newStatus      = $_POST['status']           ?? '';
        $newTags        = $_POST['tags']             ?? [];

        if ($newTitle === '') {
            $errors[] = 'Titulek je povinný.';
        }
        if (!in_array($newStatus, ['unclaimed','claimed','finished'], true)) {
            $errors[] = 'Vyberte platný stav úkolu.';
        }

        if (empty($errors)) {
            // aktualizace úkolu
            if ($isOwner) {
                $taskModel->update($taskId, $newTitle, $newDescription);
                $taskModel->updateStatus($taskId, $newStatus);
            } else {
                $pdo->prepare(
                    'UPDATE tasks
                     SET title = :title,
                         description = :desc,
                         status = :status,
                         updated_at = NOW()
                     WHERE id = :id'
                )->execute([
                    'title'   => $newTitle,
                    'desc'    => $newDescription,
                    'status'  => $newStatus,
                    'id'      => $taskId
                ]);
            }

            // aktualizace tagů
            $pdo->prepare('DELETE FROM task_tags WHERE task_id = :tid')
                ->execute(['tid' => $taskId]);
            if (!empty($newTags)) {
                $taskModel->assignTags($taskId, $newTags);
            }

            $success[] = 'Úkol byl uložen.';
            $title        = $newTitle;
            $description  = $newDescription;
            $status       = $newStatus;
            $selectedTags = $newTags;
        }
    }

    // 4) Sdílení (pouze vlastník)
    if ($action === 'share' && $isOwner) {
        $email = trim($_POST['share_email'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Zadejte platný e-mail.';
        } elseif (!$shareModel->shareByEmail($taskId, $email, $_SESSION['user_id'])) {
            $errors[] = 'Sdílení se nezdařilo.';
        } else {
            $success[] = "Pozvánka odeslána na {$email}.";
        }
        // obnovit seznam sdílených
        $sharedUsers = $shareModel->getSharedUsers($taskId);
    }
}
?>

<h3 class="mb-1">Úprava úkolu</h3>
<p class="text-muted mb-4">
  Vytvořeno: <?= date('j.n.Y H:i', strtotime($createdAt)) ?><br>
  Poslední změna: <?= date('j.n.Y H:i', strtotime($updatedAt)) ?>
</p>

<?php if ($errors): ?>
  <div class="alert alert-danger"><ul class="mb-0">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul></div>
<?php endif; ?>
<?php if ($success): ?>
  <div class="alert alert-success"><ul class="mb-0">
    <?php foreach ($success as $m): ?><li><?= htmlspecialchars($m) ?></li><?php endforeach; ?>
  </ul></div>
<?php endif; ?>

<form method="post" class="mb-4">
  <input type="hidden" name="action" value="save">

  <div class="mb-3">
    <label class="form-label">Titulek</label>
    <input type="text" name="title" class="form-control" required
           value="<?= htmlspecialchars($title) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Popis</label>
    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($description) ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Stav úkolu</label>
    <select name="status" class="form-select" required>
      <option value="unclaimed" <?= $status==='unclaimed'?'selected':'' ?>>Nepřiřazené</option>
      <option value="claimed"   <?= $status==='claimed'  ?'selected':'' ?>>Rozdělané</option>
      <option value="finished"  <?= $status==='finished' ?'selected':'' ?>>Dokončené</option>
    </select>
  </div>

  <div class="mb-4">
    <label class="form-label">Tagy</label>
    <div>
      <?php foreach ($allTags as $tag):
        $chk = in_array($tag['id'], $selectedTags) ? 'checked' : ''; ?>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox"
                 id="tag<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>"
                 <?= $chk ?>>
          <label class="form-check-label" for="tag<?= $tag['id'] ?>"
                 style="background-color:<?=htmlspecialchars($tag['color'])?>;color:#fff;padding:.2em .6em;border-radius:.25rem;">
            <?= htmlspecialchars($tag['name']) ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>

  <div class="d-flex gap-2 mt-4">
    <button type="submit" name="action" value="save" class="btn btn-primary">Uložit změny</button>
    <a href="dashboard.php" class="btn btn-secondary">Zpět na dashboard</a>
    <?php if ($isOwner): ?>
      <button type="submit" name="action" value="delete"
              onclick="return confirm('Opravdu chcete smazat tento úkol?')"
              class="btn btn-danger">Smazat úkol</button>
    <?php endif; ?>
    <?php if ($isSharedUser): ?>
      <button type="submit" name="action" value="unshare_self"
              onclick="return confirm('Chcete odebrat svůj přístup?')"
              class="btn btn-outline-danger">Ukončit sdílení</button>
    <?php endif; ?>
  </div>
</form>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Sdílení úkolu</h5>

    <?php if (empty($sharedUsers)): ?>
      <p class="text-muted">Úkol není sdílen s nikým.</p>
    <?php else: ?>
      <ul class="list-group mb-3">
        <?php foreach ($sharedUsers as $u): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= htmlspecialchars("{$u['name']} ({$u['email']}) [{$u['status']}]") ?>
            <?php if ($isOwner): ?>
              <form method="post">
                <input type="hidden" name="action" value="unshare">
                <input type="hidden" name="unshare_user_id" value="<?= $u['user_id'] ?>">
                <button class="btn btn-sm btn-outline-danger">&times;</button>
              </form>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if ($isOwner): ?>
      <form method="post" class="d-flex gap-2">
        <input type="hidden" name="action" value="share">
        <input type="email" name="share_email" class="form-control" placeholder="E-mail uživatele" required>
        <button class="btn btn-success">Sdílet</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
