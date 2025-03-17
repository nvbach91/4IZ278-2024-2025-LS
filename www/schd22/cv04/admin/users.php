<?php
require '../utils/utils.php';
$users = fetchUsers();
?>

<?php include '../incl/header.php'; ?>

<link rel="stylesheet" href="../css/admin.css">

<div class="container">
    <h1 class="text-center">Registered Users</h1>
    <p class="text-center">Total users: <strong><?php echo count($users); ?></strong></p>
    
    <?php if (empty($users)) : ?>
        <p class="text-center text-muted">No registered users yet.</p>
    <?php else : ?>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $index++; ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<p><a class="btn btn-primary" href="../index.php">Back</a></p>

<?php include '../incl/footer.php'; ?>
