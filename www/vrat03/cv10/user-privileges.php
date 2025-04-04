<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/UsersDB.php';?>
<?php

hasPrivilege(3);
$usersDB = new UsersDB();
$users = $usersDB->fetchAll([]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['privilege'])) {
    $userId = (int)$_POST['user_id'];
    $privilege = (int)$_POST['privilege'];
    $usersDB->updatePrivilege($userId, $privilege);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class="container">
    <h2>Manage User Privileges</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Privilege</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                            <select name="privilege">
                                <option value="1" <?php echo $user['privilege'] == 1 ? 'selected' : ''; ?>>User</option>
                                <option value="2" <?php echo $user['privilege'] == 2 ? 'selected' : ''; ?>>Manager</option>
                                <option value="3" <?php echo $user['privilege'] == 3 ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>