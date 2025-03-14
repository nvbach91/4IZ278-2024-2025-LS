<?php
require "utils.php";
require_once "classes/User.php";

require "head.php";



session_start();



if (isset($_SESSION['user'])) {
    header('Location: profile.php');
}

$errors = [];

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        array_push($errors, 'Email is not valid');
    }
    if (empty($password)) {
        array_push($errors, 'Password is required');
    }



    if ($errors == []) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $user = fetchUser($email);

        if ($user === null) {
            array_push($errors, 'User not found');
        } else {
            if ($user->password !== $password) {
                array_push($errors, 'Password is incorrect');
            }
        }

        if ($errors == []) {
            $_SESSION['user'] = serialize($user);
            header('Location: profile.php');
            exit();
        }
    }
}

?>
<h1> Login </h1>
<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert"> <?php echo $error ?> </div>
<?php endforeach ?>
<?php if (empty($errors) && !empty($_POST)) : ?>
    <div class="alert alert-success" role="alert"> Form was submitted successfully </div>
<?php endif ?>

<div class="form-container">
    <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo $_GET['email'] ?? '' ?>">
        </div>
        <label>Password*</label>
        <input type="password" class="form-control" name="password" value="">

        <button class="submit-btn" type="submit">Submit</button>
</div>

</form>
</div>

<?php
require "footer.php";
?>