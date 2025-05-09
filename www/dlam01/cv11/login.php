<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php

require __DIR__ . "/database/UsersDB.php";

$usersDB = new UsersDB();

$success;
$errors = [];

if (!empty($_GET["email"])) {
    $email = $_GET["email"];
    $success = "Your account has been successfully registered, you can now log in.";
}

if (!empty($_POST)) {

    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    $user = $usersDB->fetchByEmail($email);

    if (!($user)) {
        $errors["email"] = "Email was not registered";
    } elseif (!password_verify($password, $user["password"])) {
        $errors["password"] = "Password is not valid";
    }

    if (empty($errors)) {
        $success = "You have successfully logged in.";
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["privilege"] = $user["privilege"];
        header("Location: index.php");
    }
}
?>
<main class="container">
    <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" class="form-register">
        <h1>Login</h1>
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors["email"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["email"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Email address*</label>
            <input name="email" class="form-control" aria-describedby="emailHelp"
                value="<?php echo isset($email) ? $email : "" ?>">
            <div id="emailHelp" class="form-text">Enter a valid email address e.g. pepa@gmail.com</div>
        </div>

        <?php if (isset($errors["password"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["password"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Password*</label>
            <input name="password" class="form-control" aria-describedby="password" type="password">
            <div id="emailHelp" class="form-text">Enter a password</div>
        </div>

        <button type="Submit" class="btn btn-primary">Sign in</button>
    </form>
    <a href="register.php">Don't have an account yet? Register now!</a>
</main>
<div style="padding-bottom:20px"></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>