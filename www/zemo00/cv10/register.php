<?php
include __DIR__ . "/incl/head.html";
require_once __DIR__ . "/Database/UsersDB.php";

$error = '';
$email = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if($email === '' || $password === ''){
        $error = 'Some credentials are missing.';
    } else {
        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $usersDB = new UsersDB();
        $usersDB->insert($data);

        header('Location: index.php');
        exit;
    }
}




?>



<div class="form-container">
<h2>Login</h2>
<form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label class="label" for="email">Email:</label>
    <input class="input" type="email" name="email" id="email"
        value="<?php echo $email; ?>">
    <label class="label" for="password">Password:</label>
    <input class="input" type="password" name="password" id="password">
    <button class="button" type="submit">Register</button>
    <a href="index.php">Log in</a>
    <?php if($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
</form>
</div>



<?php
include __DIR__ . "/incl/foot.html";
?>