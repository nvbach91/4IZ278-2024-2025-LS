<?php
// sp/new_task.php

$pageTitle = 'Nový úkol';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/Task.php';
require_once __DIR__ . '/database/Tag.php';

use App\DatabaseConnection;
use App\Auth;
use App\Task;
use App\Tag;

$auth = new Auth(DatabaseConnection::getPDOConnection());
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$pdo       = DatabaseConnection::getPDOConnection();
$taskModel = new Task($pdo);
$tagModel  = new Tag($pdo);

$errors      = [];
$title       = '';
$description = '';
$selectedTags = [];

$allTags = $tagModel->getAll($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = trim($_POST['title']       ?? '');
    $description  = trim($_POST['description'] ?? '');
    $selectedTags = $_POST['tags'] ?? [];

    if ($title === '') {
        $errors[] = 'Titulek je povinný.';
    }

    if (empty($errors)) {
        $newId = $taskModel->create($_SESSION['user_id'], $title, $description);
        if ($newId) {
            if ($selectedTags) {
                $taskModel->assignTags($newId, $selectedTags);
            }
            header('Location: dashboard.php');
            exit;
        }
        $errors[] = 'Chyba při vytváření úkolu.';
    }
}
?>
<h3 class="mb-4">Nový úkol</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" novalidate>
  <div class="mb-3">
    <label class="form-label">Titulek</label>
    <input
      type="text"
      name="title"
      class="form-control"
      required
      value="<?= htmlspecialchars($title) ?>"
    >
  </div>
  <div class="mb-3">
    <label class="form-label">Popis</label>
    <textarea
      name="description"
      class="form-control"
      rows="4"
    ><?= htmlspecialchars($description) ?></textarea>
  </div>
  <div class="mb-4">
    <label class="form-label">Tagy</label>
    <div>
      <?php if (empty($allTags)): ?>
        <p class="text-muted">Žádné tagy. <a href="tags.php">Vytvořte je zde</a>.</p>
      <?php else: foreach ($allTags as $tag): 
        $chk = in_array($tag['id'], $selectedTags) ? 'checked' : ''; ?>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="checkbox"
            id="tag<?= $tag['id'] ?>"
            name="tags[]"
            value="<?= $tag['id'] ?>"
            <?= $chk ?>
          >
          <label class="form-check-label" for="tag<?= $tag['id'] ?>"
                 style="background-color:<?=htmlspecialchars($tag['color'])?>;color:#fff;padding:.2em .6em;border-radius:.25rem;">
            <?= htmlspecialchars($tag['name']) ?>
          </label>
        </div>
      <?php endforeach; endif; ?>
    </div>

    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-primary">Vytvořit úkol</button>
      <a href="dashboard.php" class="btn btn-secondary">Zpět na dashboard</a>
    </div>
</form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
