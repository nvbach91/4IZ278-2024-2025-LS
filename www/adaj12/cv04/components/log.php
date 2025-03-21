<?php
require './functions/users.php';

$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$registered = isset($_GET['registered']) ? true : false;
$loginMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $user = fetchUser($email);

    if ($user === null) {
        $loginMessage = "User does not exist.";
    } elseif ($password !== $user[1]) {
        $loginMessage = "Incorrect password.";
    } else {
        $loginMessage = "Login successful!";
    }
}
?>

<?php if ($registered): ?>
    <div class="alert alert-success">
        Registration successful! You can now log in.
    </div>
<?php endif; ?>
<?php if ($loginMessage): ?>
    <div class="alert alert-<?php echo $loginMessage === 'Login successful!' ? 'success' : 'danger'; ?>">
        <?php echo $loginMessage; ?>
    </div>
<?php endif; ?>
<form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label>Email*</label>
        <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="form-group">
        <label>Password*</label>
        <input class="form-control" type="password" name="password">
    </div>
    <button class="btn btn-primary" type="submit">Login</button>
</form>