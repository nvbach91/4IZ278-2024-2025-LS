<?php
require __DIR__ . '/config/global.php';
require __DIR__ . '/db/ProductsDB.php';
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/UsersDB.php';
session_start();
$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);
$usersDB = new UsersDB($connection);
if (!isset($_SESSION['user_email']) || $usersDB->checkUserPrivilege($_SESSION['user_email']) != 3) {
    header('Location: login.php');
    exit();
}
$users = $usersDB->getAllUsers();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['user_id'] ?? 0);
    $privilege = intval($_POST['privilege'] ?? 0);
    if ($userId > 0 && in_array($privilege, [1, 2, 3], true)) {
        $usersDB->updateUserPrivileges($userId, $privilege);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

?>
<?php require './incl/header.php'; ?>
<div class="container mt-5">

    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Uživatelé</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Privilegium</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['user_id'] ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <form method="post" class="d-flex flex-wrap align-items-center gap-2">
                                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                            <select name="privilege" class="form-select form-select-sm" style="width: auto;">
                                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $i == $user['privilege'] ? 'selected' : '' ?>>
                                                        <?= $i ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Uložit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/incl/footer.php'; ?>