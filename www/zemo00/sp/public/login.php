<?php

require __DIR__ . "/../app/views/partials/head_login.php";
require_once __DIR__ . "/../app/models/UserDB.php";

$errors = [];
$userDB = new UserDB;

session_start();

// === Handle form submission ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userDB->fetchByEmail($email);

    if ($user) {
        if(!password_verify($password, $user['password'])) {
            $errors[] = "Incorrect password.";
        } elseif (!$userDB->isVerified($email)) {
            $errors[] = "Please verify your email before logging in.";
        } else {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['privilege'] = $user['privilege'];

            if ($_SESSION['privilege'] == 3) {
                header("Location: /~zemo00/sp/admin");
                exit;
            }

            header("Location: /~zemo00/sp/home");
            exit;
        }
    } else {
        $errors[] = "A user with this email does not exist.";
    }

}

?>

<!-- === Login form === -->
<form action="/~zemo00/sp/login" method="POST" class="container mt-5" style="max-width: 400px;">
    <h1 class="mb-4 text-center">Login</h1>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="text-end mb-3">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
    <!-- === Errors === -->
    <?php if (!empty($errors)):?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <div><strong><?php echo htmlspecialchars($error); ?></strong></div>
            <?php endforeach; ?>    
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between mt-3">
        <a href="/~zemo00/sp/register">Register</a>
        <a href="/~zemo00/sp/login-google.php">Login with Google</a>
    </div>
</form>

<?php

include __DIR__ . "/../app/views/partials/foot.html";

?>