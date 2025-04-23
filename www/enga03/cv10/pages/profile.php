<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['username'])) {
    echo "You are not logged in.";
    exit;
}
?>
<main class="container">
    <h1>Profile</h1>
    <h3>You are signed in as: <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    <a href="logout.php" class="btn btn-primary">Sign out</a>
</main>

<?php require __DIR__ . '/../includes/footer.php';?>