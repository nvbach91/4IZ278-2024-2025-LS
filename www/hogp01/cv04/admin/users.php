<?php
require '../src/utils.php';

$users = fetchUsers('../users.db');

?>
<?php include '../src/header.php'; ?>
    <div class="wrapper">
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php include '../src/footer.php'; ?>