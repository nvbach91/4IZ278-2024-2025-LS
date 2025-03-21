<?php
require 'src/utils.php';

$error = "";
$success = false;
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ( empty($email) || empty($password) ) {
        $error .= "One or more fields empty.<br>";

    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Invalid email format.<br>";
        } else {
            if (authenticate($email,$password) === null) {
                $error .= "User doesnt exist.<br>";
            } elseif (authenticate($email,$password) === false) {
                $error .= "Wrong password.<br>";
            } elseif (authenticate($email,$password) === true) {
                $success = true;
            }
        }

    }
}

?>
<?php include 'src/header.php'; ?>
    <div class="wrapper">
        <form class="form-signup" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <div class="alert alert-danger">
                <?php  echo isset($_GET['email']) ? 'Registrace proběhla úspěšne!' : ""?>
                <p style="color:red"><?php  echo $error != '' ? $error : "" ?></p>
                <p style="color:lime"><?php  echo $success ? 'Prihlášení proběhlo úspěšne!' : ""?></p>
            </div>
            <div class="form-group">
                <label>Email*</label>
                <input class="form-control" name="email" value="<?= (isset($_GET['email']) && !isset($email)) ? $_GET['email'] : '' ?><?= isset($email) ? $email : '' ?>">
            </div>
            <div class="form-group">
                <label>Password*</label>
                <input type="password" class="form-control" name="password" value="<?= isset($password) ? $password : '' ?>">
            </div>
            <button class="btn btn-primary" type="submit">Přihlásit se</button>
        </form>
    </div>
<?php include 'src/footer.php'; ?>