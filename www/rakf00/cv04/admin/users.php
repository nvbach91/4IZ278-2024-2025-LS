<?php
require_once __DIR__. "/../utils/fileReader.php";

$users = fetchUsers();
?>

<?php include __DIR__ . "/../includes/head.php" ?>
<main>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
    <?php foreach ($users as $email => $user) :?>
            <tr>
                <td><?= $user["name"] ?></td>
                <td><?= $email ?></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php include __DIR__ . "/../includes/foot.php" ?>

