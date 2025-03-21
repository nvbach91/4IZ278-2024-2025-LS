<?php
require __DIR__ . '/../utils/database.php';
$users = fetchUsers();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>All Users</h2>
        <?php if (empty($users)): ?>
            <div class="alert alert-info">No users found</div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">Back to registration</a>
    </div>
</body>

</html>