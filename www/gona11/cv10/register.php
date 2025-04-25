<?php require_once __DIR__ . '/database/UsersDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>

<?php 
    $usersDB = new UsersDB();
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = [];
        if(empty($name)) {
            $errors['name'] = "Enter your name";
        }
        if(empty($email)) {
            $errors['email'] = "Enter your email";
        }
        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] ='Enter a valid email';
        }
        if(empty($password)) {
            $errors['password'] = "Enter your password";
        }
        if(empty($password)) {
            $errors['password'] = "Enter your password";
        }

        if(empty($errors)) {
            $usersDB->insertUser($name, $email, $passwordHash, 1);
            $_SESSION["registrationSuccess"] = "Account successfully registered!";
            header('Location: ./login.php');
            exit();
        }
    }

?>

    <div class="flex">
        <h3 class="m-3">Register a new account</h3>
        <form class="form-signup flex-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">

            <?php if(isset($errors['name'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['name'];?></div>
            <?php endif; ?>
            <div class="form-group m-1">
                <label class="ml-3">Full name</label>
                <input 
                    class="form-control m-3"
                    name="name"
                    value="<?php echo isset($name) ? $name : '';?>">
            </div>

            <?php if(isset($errors['email'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['email'];?></div>
            <?php endif; ?>
            <div class="form-group m-1">
                <label class="ml-3">Email</label>
                <input 
                    class="form-control m-3"
                    name="email"
                    value="<?php echo isset($email) ? $email : '';?>">
            </div>

            <?php if(isset($errors['password'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['password'];?></div>
            <?php endif; ?>
            <div class="form-group m-1">
                <label class="ml-3">Password</label>
                <input 
                    class="form-control m-3"
                    type="password"
                    name="password"
                    value="<?php echo isset($password) ? $password : '';?>">
            </div>
            <button class="btn btn-primary pl-4 pr-4" type="submit">Register</button>
        </form>
    </div>

<?php include __DIR__ . '/includes/foot.php'?>