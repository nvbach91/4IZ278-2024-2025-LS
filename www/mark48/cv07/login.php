<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pokud je uživatel již přihlášen (podle session), přesměrujeme ho na hlavní stránku
if (isset($_SESSION['name'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        $error = "Prosím vyplňte uživatelské jméno.";
    } else {
        $_SESSION['name'] = $username;

        header("Location: index.php");
        exit;
    }
}

require "head.php";
?>

<div class="container">
    <h2 class="mt-5">Přihlášení</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Uživatelské jméno</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Zadejte uživatelské jméno" required>
        </div>
        <button type="submit" class="btn btn-primary">Přihlásit se</button>
    </form>
</div>

<?php
require "footer.php";
?>