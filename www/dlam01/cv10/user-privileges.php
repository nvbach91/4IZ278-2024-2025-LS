<?php
session_start();
if ($_SESSION['privilege'] < '3') {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/database/UsersDB.php';
$usersDB = new UsersDB();
$users = $usersDB->fetch([]);

?>
<?php include_once __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <h1>Admin table</h1>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Privilege</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user["id"] ?></td>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["privilege"] ?></td>
                    <td><a href="edit-user.php?id=<?= $user["id"] ?>" class="btn btn-primary">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php include_once __DIR__ . '/includes/footer.php'; ?>