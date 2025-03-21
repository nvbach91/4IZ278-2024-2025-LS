<?php require __DIR__ . '/functions.php'?>
<?php 
session_start();

$success = "";

if(isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
    unset($_SESSION["success"]);
}

$isSubmittedForm = !empty($_POST);
if($isSubmittedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $errors = [];
    
    if(empty($email)) {
        $errors['email'] = "Enter your email";
    }

    if(!empty($email)) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] ='Enter a valid email';
        } else if(!checkExistingUser($email)) {
            $errors['email'] = "This email is not registered yet";
        }
    }

    if(empty($password)) {
        $errors['password'] = "Enter your password";
    }

    if(getUserPassword($email) !== $password) {
        $errors['password'] = "Wrong password";
    }

    if(empty($errors)) {
        header('Location: ./success.php');
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
        <link rel="stylesheet" href="./style.css">
        <title>CV04 || Registration website</title>
    </head>
    <body>
    <div class="flex">
        <h1>Log in</h1>
        <form  method="POST" action="<?php echo  $_SERVER['PHP_SELF'] ?>">

            <?php if(!empty($success)) :?>
                <div class="alert alert-success mt-3"><?php echo htmlspecialchars($success);?></div>
            <?php endif; ?>

            <?php if(isset($errors['email'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['email'];?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <label>Email</label>
                <input 
                    class="form-control"
                    name="email"
                    value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : (isset($email) ? $email : ''); ?>">
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
            </div>  

            <button class="btn btn-primary mt-3" type="submit">Log in</button>
        </form>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>