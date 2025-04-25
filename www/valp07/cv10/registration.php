<?php
require __DIR__ . '/config/global.php';
require __DIR__ . '/db/ProductsDB.php';
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/UsersDB.php';
$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);

$error = null;
$email = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        try {
            if ($usersDB->findUserByEmail($email)) {
                $error = "Email is already registered!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $usersDB->create([
                    'email' => $email,
                    'password' => $hashedPassword,
                ]);

                header('Location: index.php');
                exit();
            }
        } catch (Exception $e) {
            $error = "Registration failed. Please try again later.";
        }
    }
}
?>

<?php require './incl/header.php'; ?>
<main class="container pt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h1 class="mb-4 text-center">Register</h1>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <div class="form-group mb-3">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" 
                 placeholder="Enter your email"
                 value="<?= htmlspecialchars($email) ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" 
                 name="password" placeholder="Enter a password" required>
        </div>

        <div class="form-group mb-4">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" 
                 name="confirmPassword" placeholder="Confirm your password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
      </form>
    </div>
  </div>
</main>

<?php require __DIR__ . '/incl/footer.php'; ?>