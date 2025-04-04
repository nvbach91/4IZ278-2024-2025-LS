<?php
session_start();
if ($_SESSION['privilege'] < '1') {
    header("Location: index.php");
    exit;
}
?>
<?php require_once __DIR__  . "/includes/header.php"; ?>
<main class="container">
    <h1>Profile</h1>
    <p>Welcome to your profile page <?= explode("@",$_SESSION["email"])[0]; ?></p>
</main>
<?php require_once __DIR__  . "/includes/footer.php"; ?>