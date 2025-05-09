<?php

require_once __DIR__ . '/database/UsersDB.php';

$usersDB = new UsersDB();

$sucess;
$errors = [];

if (!empty($_POST)) {
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirm = htmlspecialchars(trim($_POST["confirm"]));

    //validation

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
    }

    if (!empty($usersDB->fetchByEmail($email))) {
        $errors["email"] = "Account with this email address has already been registred";
    }

    if (strlen($password) < 8) {
        $errors["password"] = "Password is not valid";
    }

    if ($password !== $confirm) {
        $errors["confirm"] = "Passwords do not match";
    }

    if (empty($errors)) {

        $usersDB->insert($email, $password, 1);

        $success = "User has been successfully registered";

        header('Location: ' . "login.php?email=" . $_POST["email"]);
    }
}
?>

<?php include __DIR__ . "/includes/header.php"; ?>
<main class="container">
    <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" class="form-register">
        <h1>Registration</h1>

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
            <div id="emailHelp" class="form-text">Enter a password, password must 8 characters or longer</div>
        </div>

        <?php if (isset($errors["confirm"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["confirm"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Confirm password*</label>
            <input name="confirm" class="form-control" aria-describedby="confirm" type="password">
            <div id="emailHelp" class="form-text">Confirm your password</div>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div style="padding-bottom:20px"></div>
</main>
<?php include __DIR__ . "/includes/footer.php"; ?>