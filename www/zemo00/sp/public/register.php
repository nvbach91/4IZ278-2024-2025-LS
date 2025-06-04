<?php

require __DIR__ . "/../app/views/partials/head_login.php";

$errors = [];
$success_message = null;

// === Handle form submission ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require __DIR__ . "/../app/utils/validation.php";
    require_once __DIR__ . "/../app/models/UserDB.php";

    $userDB = new UserDB();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $repeat = $_POST['repeat'] ?? '';

    // === Validate input fields ===
    if (!fieldsNotEmpty($_POST)){
        $errors[] = "All fields are required.";
    } else {

        if (!validateEmailFormat($email)) {
            $errors[] = "Invalid email format.";
        }

        if (!validateDomain($email)) {
            $errors[] = "Your email domain is not permitted.";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if ($password !== $repeat) {
            $errors[] = "Passwords do not match.";
        }

        if ($userDB->fetchByEmail($email)) {
            $errors[] = "This email is already registered.";
        }
    
    }

    // === Register the user if no errors ===
    if (empty($errors)){

        $token = bin2hex(random_bytes(32));

        $userDB->insert([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'verification_token' => $token
        ]);

        require_once __DIR__ . "/../app/utils/mailing.php";
        sendVerificationMail($email, $token);

        $success_message = "A verification email has been sent to your email address.";
    }
}

?>

<!-- === Registration form === -->
<form action="/~zemo00/sp/register" method="POST" class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Registration</h2>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" class="form-control"
            value="<?php echo htmlspecialchars($email ?? ''); ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label for="repeat" class="form-label">Confirm password:</label>
        <input type="password" name="repeat" class="form-control">
    </div>
    <div class="text-end mb-3">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>

    <!-- === Errors === -->
    <?php if (!empty($errors)):?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <div><strong><?php echo htmlspecialchars($error); ?></strong></div>
            <?php endforeach; ?>    
        </div>
    <?php endif; ?>

    <!-- === Success message === -->
    <?php if ($success_message != null): ?>
        <div class="alert alert-success">
            <strong><?php echo htmlspecialchars($success_message); ?></strong>
        </div>
    <?php endif;?>
    <div class="text-center mt-3">
        <a href="/~zemo00/sp/login">Login</a>
    </div>
</form>

<?php

include __DIR__ . "/../app/views/partials/foot.html";

?>