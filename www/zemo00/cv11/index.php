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

        $usersDB = new UsersDB();

        $args = [
            'columns' => ['user_id', 'password', 'privilege'],
            'conditions' => ["email = :email"],
            ':email' => $email
        ];
        $data = $usersDB->fetch($args);

        if($data && password_verify($password, $data[0]['password'])){
            session_start();
            $_SESSION['user_id'] = $data[0]['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['privilege'] = $data[0]['privilege'];

            header('Location: home.php');
            exit;
        } else{
            $error = 'Invalid email or password.';
        }


    }
}

session_start();
if (isset($_SESSION['flash_message'])) {
    echo "<script>alert('" . addslashes($_SESSION['flash_message']) . "');</script>";
    unset($_SESSION['flash_message']);
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
    <button class="button" type="submit">Login</button>
    <a href="register.php">Register</a>
    <?php if($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
</form>
</div>



<?php
include __DIR__ . "/incl/foot.html";
?>