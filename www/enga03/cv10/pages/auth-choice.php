<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../includes/header.php';
?>

<div class="container text-center">
    <h1 class="my-4">Welcome!</h1>
    <p>Please choose an option:</p>
    <a href="login.php" class="btn btn-primary mx-2">Login</a>
    <a href="registration.php" class="btn btn-success mx-2">Register</a>
    <p>
        Ukázkové účty:
        <br>
        User heslo: heslo - normální privilegia
        <br>
        Admin heslo: heslo - nejvyšší privilegium
    </p>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>