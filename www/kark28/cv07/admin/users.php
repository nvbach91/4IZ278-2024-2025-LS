<?php require __DIR__ . '/../database/UserDB.php';

$usersDB = new UserDB();
$users = $usersDB->find();
?>

<?php 
$contextPath = '..';
require __DIR__ . '/../includes/header.php'; ?>

<main class="container">
    <h2>Users</h2>
    <?php foreach($users as $user): ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $user['name']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $user['email']; ?></h6>
        </div>
    </div>
    <?php endforeach; ?>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>