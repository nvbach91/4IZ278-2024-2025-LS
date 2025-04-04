<?php
require_once __DIR__ . '/database/UsersDB.php';

session_start();
if ($_SESSION['privilege'] < '3') {
    header("Location: index.php");
    exit;
}

$usersDB = new UsersDB();
if (!isset($_GET["id"])) {
    header("Location: user-privileges.php");
    exit;
}

$user = $usersDB->fetchById($_GET["id"]);
if (!$user) {
    header("Location: user-privileges.php");
    exit;
}

if (!empty($_POST)) {
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirm = htmlspecialchars(trim($_POST["confirm"]));
    $privilege = htmlspecialchars(trim($_POST["privilege"]));

    //validation

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
    }

    if (!empty($usersDB->fetchByEmail($email)) && $email !== $user["email"]) {
        $errors["email"] = "Account with this email address already exists";
    }

    if (strlen($password) < 8) {
        $errors["password"] = "Password is not valid";
    }

    if ($password !== $confirm) {
        $errors["confirm"] = "Passwords do not match";
    }

    if (empty($errors)) {

        $usersDB->update($user["id"], $email, $password, $privilege);
        header('Location: ' . "user-privileges.php");
    }
}

?>
<?php include './includes/header.php'; ?>
<main class="container">
    <h1>Edit user</h1>
    <form action=<?php echo $_SERVER['PHP_SELF'] . "?id=" . $_GET["id"]?> method="POST" class="form-register">
        <?php if (isset($errors["email"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["email"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user["email"] ?>">
        </div>
        
        <div class="mb-3">
            <label for="privilege" class="form-label">Privilege</label>
            <input class="form-control" id="privilege" name="privilege" value="<?= $user["privilege"] ?>">
        </div>

        <?php if (isset($errors["password"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["password"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <?php if (isset($errors["confirm"])): ?>
            <div class='alert alert-danger' role='alert'>
                <?php echo $errors["confirm"]; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="confirm" class="form-label">Confirm password</label>
            <input type="password" class="form-control" id="confirm" name="confirm">
        </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
</main>
<?php include './includes/footer.php'; ?>