<?php require __DIR__ . '/functions.php'?>
<?php 
session_start();

$isSubmittedForm = !empty($_POST);

if($isSubmittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password_repeat = htmlspecialchars(trim($_POST['password_repeat']));

    $errors = [];

    // name
    if(empty($name)) {
        $errors['name'] = "Enter your name";
    }
    //email
    if(empty($email)) {
        $errors['email'] = "Enter your email";
    }

    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] ='Enter a valid email';
    }

    if(checkExistingUser($email)) {
        $errors['email'] ='This email is already in use by different user';
    }
    //password
    if(empty($password)) {
        $errors['password'] = 'Enter password';
    }

    if(strlen($password) < 8) {
        $errors['password'] = 'Your password is not long enough';
    }
    //password check
    if(empty($password_repeat)) {
        $errors['password_repeat'] = 'Enter your password again';
    }

    if($password !== $password_repeat) {
        $errors['password_repeat'] = 'Passwords do not match';
    }

    if(empty($errors)) {
        registerNewUser([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        $_SESSION['success'] = "Registration successful!";
        $email = urlencode($_POST['email']); // nebo $_GET['email'] podle metody formuláře
        header("Location: ./login.php?email=" . $email);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="style.css">
        <title>CV04 || Registration website</title>
    </head>
    <body>
    <div class="flex">
        <h1>Create an account</h1>
        <form  method="POST" action="<?php echo  $_SERVER['PHP_SELF'] ?>">

            <?php if(isset($errors['success'])) :?>
                <div class="alert alert-success mt-3"><?php echo $errors['success'];?></div>
            <?php endif; ?>

            <?php if(isset($errors['name'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['name'];?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <label>Name</label>
                <input 
                    class="form-control"
                    name="name"
                    value="<?php echo isset($name) ? $name : ''; ?>">
            </div>

            <?php if(isset($errors['email'])) : ?>
            <div class="alert alert-danger mt-3"><?php echo $errors['email'];?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <label>Email</label>
                <input 
                    class="form-control"
                    name="email"
                    value="<?php echo isset($email) ? $email : ''; ?>">
            </div>

            <?php if(isset($errors['password'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['password'];?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <label>Password</label>
                <input 
                    class="form-control"
                    name="password"
                    value="<?php echo isset($password) ? $password : ''; ?>">
                <div id="passwordHelpBlock" class="form-text">Minimal password length: 8</div>
            </div>

            <?php if(isset($errors['password_repeat'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['password_repeat'];?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <label>Repeat password</label>
                <input 
                    class="form-control"
                    name="password_repeat"
                    value="<?php echo isset($password_repeat) ? $password_repeat : ''; ?>">
            </div>     


            <button class="btn btn-primary mt-3" type="submit">Register</button>
        </form>
        </div>

    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>