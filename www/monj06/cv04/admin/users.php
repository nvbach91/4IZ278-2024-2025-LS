<?php
include '../includes/header.php';
require(__DIR__ . "/../components/registration.php");

$users = fetchUsers();

?>

<main class="container">

    <?php foreach ($users as $user) : ?>


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User <?php echo $user['name']; ?></h5>
                <p>name: <?php echo $user['name']; ?></p>
                <p>surname: <?php echo $user['lastName']; ?></p>
                <p>email: <?php echo $user['email']; ?></p>
                <p>password: <?php echo $user['password']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</main>
<?php include '../includes/footer.php'; ?>