<?php
require 'src/utils.php';
$error = "";

if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error .= "One or more fields empty.<br>";

    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Invalid email format.<br>";
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $error .= "Invalid name. Only letters and white space allowed.<br>";
        }

        if (fetchUser($email) !== null) {
            $error .= "User with specified email allready exists.<br>";
        }

        if ($password != $confirm_password) {
            $error .= "Passwords dont match.<br>";
        }

        if ($error == "") {
            if (registerNewUser($name,$email,$password)) {
                mail($email, "Registration Successful", "Your registration was successful!");
                header("Location: login.php?email=" . urlencode($email));
            }
        }

    }
}

?>
<?php include 'src/header.php'; ?>
    <div class="wrapper">
        <form class="form-signup" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <div class="alert alert-danger"><?php  echo ($error == '' && !empty($_POST)) ? 'Registrace proběhla úspěšne!' : $error?></div>
            <div class="form-group">
                <label>Name*</label>
                <input class="form-control" name="name" value="<?= isset($name) ? $name : '' ?>">
            </div>
            <div class="form-group">
                <label>Email*</label>
                <input class="form-control" name="email" value="<?= isset($email) ? $email : '' ?>">
            </div>
            <div class="form-group">
                <label>Password*</label>
                <input type="password" class="form-control" name="password" value="<?= isset($password) ? $password : '' ?>">
            </div>
            <div class="form-group">
                <label>Verify Password*</label>
                <input type="password" class="form-control" name="confirm_password" value="<?= isset($confirm_password) ? $confirm_password : '' ?>">
            </div>

            <button class="btn btn-primary" type="submit">Pokračovat</button>
        </form>
    </div>
<?php include 'src/footer.php'; ?>