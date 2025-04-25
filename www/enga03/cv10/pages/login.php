<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/DatabaseOperation.php';
require __DIR__ . '/../includes/header.php';

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
    unset($_SESSION['error_message']); // Clear the error message after displaying it
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbOps = new DatabaseOperation();
    $stmt = $dbOps->getConnection()->prepare("SELECT * FROM cv10_users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['privilege'] = $user['privilege'];
        $_SESSION['username'] = $user['name']; // Save the username into the session
        header('Location: ../index.php');
        exit;
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid email or password.</div>';
    }
}
?>

<main class="container">
    <h1 class="my-4">Login</h1>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>