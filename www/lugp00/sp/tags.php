<?php
// sp/tags.php

$pageTitle = 'Správa tagů';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';
require_once __DIR__ . '/database/Tag.php';

use App\DatabaseConnection;
use App\Auth;
use App\Tag;

$auth    = new Auth(DatabaseConnection::getPDOConnection());
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userId  = $_SESSION['user_id'];
$tagModel = new Tag(DatabaseConnection::getPDOConnection());

$errors  = [];
$success = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name   = trim($_POST['name']  ?? '');
    $color  = trim($_POST['color'] ?? '');
    $id     = (int)($_POST['id']  ?? 0);

    if ($action === 'create') {
        if ($name === '') $errors[] = 'Název tagu je povinný.';
        if ($color === '') $errors[] = 'Barva tagu je povinná.';
        if (empty($errors)) {
            $tagModel->create($userId, $name, $color)
                ? $success = 'Tag přidán.'
                : $errors[] = 'Chyba při vytváření tagu.';
        }
    }

    if ($action === 'update') {
        if ($name === '') $errors[] = 'Název tagu je povinný.';
        if ($color === '') $errors[] = 'Barva tagu je povinná.';
        if (empty($errors)) {
            $tagModel->update($id, $name, $color)
                ? $success = 'Tag upraven.'
                : $errors[] = 'Chyba při úpravě tagu.';
        }
    }

    if ($action === 'delete') {
        $tagModel->delete($id)
            ? $success = 'Tag smazán.'
            : $errors[] = 'Chyba při mazání tagu.';
    }
}

$tags = $tagModel->getAll($userId);
?>
<h3 class="mb-4">Správa tagů</h3>

<?php if ($errors): ?>
  <div class="alert alert-danger"><ul class="mb-0">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" class="row g-2 mb-4">
  <input type="hidden" name="action" value="create">
  <div class="col-md-6">
    <input type="text" name="name" class="form-control" placeholder="Název tagu" required>
  </div>
  <div class="col-md-2">
    <input type="color" name="color" class="form-control form-control-color" value="#cccccc" title="Barva tagu" required>
  </div>
  <div class="col-md-4">
    <button type="submit" class="btn btn-success w-100">Přidat tag</button>
  </div>
</form>

<?php if (empty($tags)): ?>
  <p class="text-muted">Žádné tagy</p>
<?php else: ?>
  <table class="table table-striped">
    <thead>
      <tr><th>Název</th><th>Barva</th><th class="text-end">Akce</th></tr>
    </thead>
    <tbody>
      <?php foreach ($tags as $tag): ?>
        <tr>
          <form method="post">
            <input type="hidden" name="id" value="<?= $tag['id'] ?>">
            <td>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($tag['name']) ?>" required>
            </td>
            <td>
              <input type="color" name="color" class="form-control form-control-color" value="<?= htmlspecialchars($tag['color']) ?>" required>
            </td>
            <td class="text-end">
              <button name="action" value="update" class="btn btn-primary btn-sm me-1">Upravit</button>
              <button name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu smazat tag?')">Smazat</button>
            </td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
