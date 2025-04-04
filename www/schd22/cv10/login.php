<?php require 'database/UsersDB.php'?>
<?php
if(!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $userDB = new UsersDB();
    $user = $userDB->findOneByEmail($email);

    if($user == null){
        echo "User not found";
        exit;
    }
    $isPasswordCorrect = password_verify($password, $user['password']) or die("Invalid password");
    if (!$isPasswordCorrect) {
        echo "Invalid password";
        exit;
    }

    echo 'User autheticated';
    session_start();
    $_SESSION['user'] = $user['email'];
    $_SESSION['privilege'] = $user['privilege'];
    header('Location: index.php');
    exit;
}
?>
<?php require_once 'incl/header.php'; ?>
<div class="container mt-5">
    <h1>Login</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label for="email">Email</label>
            <input name="email" type="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input name="password" type="password" required>
        </div>
        <button type="submit">Submit</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>