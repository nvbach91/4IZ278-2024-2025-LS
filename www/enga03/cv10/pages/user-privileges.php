<?php
require_once __DIR__ . '/database/DatabaseOperation.php';
require __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['privilege'] !== 3) {
    header('Location: login.php');
    exit;
}

$dbOps = new DatabaseOperation();
$users = $dbOps->getConnection()->query("SELECT * FROM cv10_users")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $privilege = $_POST['privilege'];

    $stmt = $dbOps->getConnection()->prepare("UPDATE cv10_users SET privilege = :privilege WHERE user_id = :user_id");
    $stmt->bindParam(':privilege', $privilege, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: user-privileges.php');
    exit;
}
?>

<main class="container">
    <h1 class="my-4">User Privileges</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Privilege</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['privilege']); ?></td>
                    <td>
                        <form method="POST" class="form-inline">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <select name="privilege" class="form-control mr-2">
                                <option value="1" <?php echo $user['privilege'] == 1 ? 'selected' : ''; ?>>User</option>
                                <option value="2" <?php echo $user['privilege'] == 2 ? 'selected' : ''; ?>>Manager</option>
                                <option value="3" <?php echo $user['privilege'] == 3 ? 'selected' : ''; ?>>Administrator</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>