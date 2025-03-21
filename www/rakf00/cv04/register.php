<?php

require_once __DIR__ . "/utils/fileReader.php";

$formValid = false;
$userExists = false;
$isSubmittedForm = !empty($_POST);
function registerNewUser($email, $password, $name): void
{
    global $userExists;
    if (fetchUser($email) == null) {
        $preparedLine = $email . ";" . $password . ";" . $name;
        writeNewLine($preparedLine);
    } else {
        $userExists = true;
    }
}

if ($isSubmittedForm) {
    $errors = [];

    $fullName = htmlspecialchars(trim($_POST["fullName"]));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

    // email validace
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format";
    }

    // jmeno validace
    if (!preg_match("/^\p{L}+ \p{L}+(?: \p{L}+)*$/u", $fullName)) {
        $errors["fullName"] = "Invalid full name";
    }

    //passwords empty
    if (empty($password)) {
        $errors["password"] = "Password cannot be empty";
    }
    if (empty($confirmPassword)) {
        $errors["confirmPassword"] = "Password cannot be empty";
    }

    // hesla validace
    if ($password !== $confirmPassword) {
        $errors["password"] = "Passwords do not match";
    }

    if (empty($errors)) {
        $formValid = true;
    }

    registerNewUser($email, $password, $fullName);

    header('Location: ./login.php?email=' . urlencode($email) . "&registered=" . ($userExists ? "false" : "true"));
    exit();
}

?>
<?php
include __DIR__ . "/includes/head.php" ?>
<main>
    <h1>Register</h1>
    <form method="POST" class="m-3" action="<?php
                                            echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="fullName">Your name</label>
            <input id="fullName" class="form-control" name="fullName"
                placeholder="Bryan Johnson" value="<?php
                                                    echo $fullName ?? "" ?>">
            <?php
            if (isset($errors["fullName"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["fullName"] ?>
                </div>
            <?php
            endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" class="form-control" name="email"
                placeholder="example@domain.com" value="<?php
                                                        echo $email ?? "" ?>">
            <?php
            if (isset($errors["email"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["email"] ?>
                </div>
            <?php
            endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="form-control" name="password"
                placeholder="Password">
            <?php
            if (isset($errors["password"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["password"] ?>
                </div>
            <?php
            endif; ?>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password id=" confirmPassword" type="text" class="form-control"
                name="confirmPassword" placeholder="Confirm Password">
            <?php
            if (isset($errors["confirmPassword"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["confirmPassword"] ?>
                </div>
            <?php
            endif; ?>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</main>
<?php
include __DIR__ . "/includes/foot.php" ?>