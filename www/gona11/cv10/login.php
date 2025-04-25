<?php require_once __DIR__ . '/database/UsersDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>

<?php 
    if(isset($_SESSION["registrationSuccess"])) {
        $registrationSuccess = $_SESSION["registrationSuccess"];
        unset($_SESSION["registrationSuccess"]);
    }

    $usersDB = new UsersDB();
    $correctPassword = false;
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $email= htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        $errors = [];

        if(empty($email)) {
            $errors['email'] = "Enter your email";
        } else if (empty($password)) {
            $errors['password'] = "Enter your password";
        } else {
            $user = $usersDB->findByEmail($email);
        }

        if(!isset($user)) {
            $errors['email'] = "User with such email does not exist";
        } else {
            $correctPassword = password_verify($password, $user['password']);
            if(!$correctPassword) {
                $errors['password'] = "Incorrect password";
            }
        }

        if(empty($errors) && $correctPassword) {
            $_SESSION["loginSuccess"] = "Logged in as " . $user['name'] . " with privilege level " . $user['privilege'] . ".";
            $_SESSION["privilege"] = $user['privilege'];
            setcookie('loginSuccess', $email, time() + 3600, "/");
            header('Location: ./index.php');
            exit();
        }
    }

?>

    <div class="flex">
        <?php if(isset($registrationSuccess)) :?>
            <div class="alert alert-success mt-3"><?php echo $registrationSuccess;?></div>
        <?php endif; ?>
        <h3 class="m-3">Log in to your account</h3>
        <form class="form-signup  flex-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">

            <?php if(isset($errors['email'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['email'];?></div>
            <?php endif; ?>
            <div class="form-group m-1">
                <label class="ml-3 mb-0">Email</label>
                <input 
                    class="form-control m-3"
                    type="email"
                    name="email"
                    value="<?php echo isset($email) ? $email : '';?>">
            </div>

            <?php if(isset($errors['password'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['password'];?></div>
            <?php endif; ?>
            <div class="form-group m-1">
                <label class="ml-3 mb-0">Password</label>
                <input 
                    class="form-control m-3"
                    type="password"
                    name="password">
            </div>
            <button class="btn btn-primary pl-4 pr-4" type="submit">Login</button>
        </form>
    </div>


<?php include __DIR__ . '/includes/foot.php'?>