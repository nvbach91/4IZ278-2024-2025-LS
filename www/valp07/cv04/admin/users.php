<?php 

require __DIR__ . '/../utils/utils.php';

$users = fetchUsers();

?>

<?php include '../includes/header.php'; ?>

<main class="container">
    <br>
    <h1 class="text-center">Users</h1>
    <?php foreach ($users as $user): ?>
        <div class="card shadow-lg bg-light my-5 rounded-3 w-75">
        <div class="card-body text-start py-4">
            <h4 class="card-title mb-2 text-primary">
                <?php echo htmlspecialchars($user['name']); ?>
            </h4>
            <h4 class="card-subtitle mb-3 text-muted">
                <?php echo htmlspecialchars($user['email']); ?>
            </h4>

        </div>
    </div>
        <br>
    <?php endforeach; ?>
</main>

<?php include '../includes/footer.php'; ?>