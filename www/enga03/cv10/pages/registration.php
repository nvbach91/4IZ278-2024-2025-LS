<?php
require_once __DIR__ . '/../database/Database.php';
require __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];

    $database = new Database();
    $pdo = $database->getConnection();

    $stmt = $pdo->prepare("INSERT INTO cv10_users (email, password, name) VALUES (:email, :password, :name)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':name', $name);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    } else {
        echo "Error: Could not register user.";
    }
}
?>

<main class="container">
    <h1 class="my-4">Register</h1>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>