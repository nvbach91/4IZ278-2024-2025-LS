<?php

include __DIR__ . "/includes/head.html";

require __DIR__ . "/utilities/user_management.php";

$email = isset($_GET['email']) ? $_GET['email'] : '';

session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

$errors = [];


$isSubmittedForm = !empty($_POST);
if($isSubmittedForm) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, 'Invalid email address');
    }
    if(authenticate($email)){
        
        if(!empty($password)){
            if(!doesPasswordMatch($email, $password)){
                array_push($errors, "Incorrect password.");
            }
        } else{
            array_push($errors, "Please provide a password.");
        }
    } else{
        array_push($errors, "A user with this email address does not exist.");
    }

    if(!empty($errors)){
        $_SESSION['message'] = '';
    }
}


?>

<h1>Login</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <?php foreach($errors as $error): ?>
        <div class="alert-danger"><?php echo $error; ?></div>
    <?php endforeach; ?>
    <?php if($message == "registered"): ?>
        <div class="success">You've successfully registered!</div>
    <?php
        $message = '';
        endif;
    ?>
    <?php if($message == "logged in"): ?>
        <div class="success">You've successfully logged in!</div>
    <?php
        $message = '';
        endif;
    ?>
    <div>
        <label for="email">Email</label>
        <input id="email" name="email"
            value="<?php echo $email; ?>">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>
    <button type="submit">Login</button>
</form>




<?php
if(empty($errors)){
    $_SESSION['message'] = "logged in";
}
include __DIR__ . "/includes/foot.html";
?>