<?php
require_once 'incl/header.php';
require_once __DIR__ . '/database/UsersDB.php';

$usersDB = new UsersDB();

// Změna oprávnění
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $userId = intval($_POST['user_id']);

        if ($userId == $_SESSION['user_id']) {
            header('Location: user-privileges.php');
            exit();
        }
        if (isset($_POST['update']) && isset($_POST['privilege'])) {
            $newPrivilege = intval($_POST['privilege']);
            $usersDB->updatePrivilege($userId, $newPrivilege);
        }
        if (isset($_POST['delete'])) {
            $usersDB->deleteById($userId);
        }

        header('Location: user-privileges.php');
        exit();
    }
}

$users = $usersDB->findAll();
?>

<div class="container mt-5">
    <h2>Správa oprávnění uživatelů</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jméno</th>
                <th>Email</th>
                <th>Oprávnění</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <?php
                        switch ($user['privilege']) {
                            case 1: echo 'Uživatel'; break;
                            case 2: echo 'Manažer'; break;
                            case 3: echo 'Admin'; break;
                        }
                    ?>
                </td>
                <td>
                    <form method="POST" class="form-inline" onsubmit="return confirm('Opravdu chcete provést akci?');">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <select name="privilege" class="form-control mr-2">
                                <option value="1" <?php if ($user['privilege'] == 1) echo 'selected'; ?>>Uživatel</option>
                                <option value="2" <?php if ($user['privilege'] == 2) echo 'selected'; ?>>Manažer</option>
                                <option value="3" <?php if ($user['privilege'] == 3) echo 'selected'; ?>>Admin</option>
                            </select>
                            <button type="submit" name="update" class="btn btn-sm btn-primary mr-2">Uložit</button>
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Vymazat</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

