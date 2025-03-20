<?php
require '../functions/users.php';
$users = fetchUsers();
?>

<h1>Registered Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user[0]); ?></td>
                <td><?php echo htmlspecialchars($user[1]); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>