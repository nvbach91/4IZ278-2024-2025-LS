<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>

<?php 
    session_start();
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $name = htmlspecialchars(trim($_POST['name']));

        $errors = [];

        if(empty($name)) {
            $errors['name'] = "Enter your name";
        }

        if(empty($errors)) {
            $_SESSION["loginSuccess"] = "Login successful!";
            setcookie('loginSuccess', $name, time() + 3600, "/");
            header('Location: ./index.php');
            exit();
        }
    }

?>

    <div class="flex">
        <h1 class="m-3">Log in to your account</h1>
        <form class="form-signup flex-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <?php if(isset($errors['name'])) : ?>
                <div class="alert alert-danger mt-3"><?php echo $errors['name'];?></div>
            <?php endif; ?>
            <div class="form-group m-3">
                <label class="ml-3 mb-0">Your name</label>
                <input 
                    class="form-control m-3"
                    name="name">
            </div>
            <button class="btn btn-primary pl-4 pr-4" type="submit">Login</button>
        </form>
    </div>

<?php include __DIR__ . '/includes/foot.php'?>