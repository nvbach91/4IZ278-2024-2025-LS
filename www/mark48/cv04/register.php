<?php

require_once "classes/User.php";
require_once "utils.php";


require "head.php";

if (isset($_SESSION['user'])) {
    header('Location: profile.php');
}


$errors = [];

if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];




    if (empty($name)) {
        array_push($errors, 'Name is required');
    }
    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        array_push($errors, 'Email is not valid');
    }
    if (empty($password)) {
        array_push($errors, 'Password is required');
    }
    if (empty($confirm_password)) {
        array_push($errors, 'Confirm Password is required');
    }
    if ($password !== $confirm_password) {
        array_push($errors, 'Passwords do not match');
    }


    if ($errors == []) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


        if (registerUser($name, $email, $password) === false) {
            array_push($errors, 'User already exists');
        } else {


            header('Location: login.php?email=' . urlencode($email));
            exit();
        }
    }
}

?>
<h1> Register </h1>
<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert"> <?php echo $error ?> </div>
<?php endforeach ?>
<?php if (empty($errors) && !empty($_POST)) : ?>
    <div class="alert alert-success" role="alert"> Form was submitted successfully </div>
<?php endif ?>

<div class="form-container">
    <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo $_POST['name'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo $_POST['email'] ?? '' ?>">
        </div>
        <label>Password*</label>
        <input type="password" class="form-control" name="password" value="<?php echo $_POST['password'] ?? '' ?>">
        <label>Confirm Password*</label>
        <input type="password" class="form-control" name="confirm-password" value="<?php echo $_POST['confirm_password'] ?? '' ?>">

        <button class="submit-btn" type="submit">Submit</button>
</div>

</form>
</div>

<?php
require "footer.php";
?>