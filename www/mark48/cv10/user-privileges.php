<?php


require_once 'auth.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// přístup pouze pro administrátora
requirePrivilege(3);

require_once 'db/DbPdo.php';
require_once 'db/UserDb.php';

$pdo = Database::getInstance()->getConnection();
$udb = new UserDb($pdo);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['user_id'] ?? 0);
    $priv   = intval($_POST['privilege'] ?? 0);
    if ($userId > 0 && in_array($priv, [1, 2, 3], true)) {
        $udb->updateUserPrivileges($userId, $priv);
        $msg = 'Úroveň oprávnění byla upravena.';
    }
}

$users = $udb->getAllUsers();


require 'head.php';
?>

<div class="container mt-5">
    <h2>Správa uživatelských oprávnění</h2>
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jméno</th>
                <th>Email</th>
                <th>Privilege</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['privilege'] ?></td>
                    <td>
                        <form method="post" class="d-flex align-items-center">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <select name="privilege" class="form-select form-select-sm me-2" style="width: auto;">
                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $user['privilege'] ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Uložit</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require 'footer.php';
?>