<?php

require __DIR__ . "/utils/fileReader.php";

$registered = $_GET["registered"] ?? null;
$email = $_GET["email"] ?? "";
$logged = $_GET["logged"]?? null;
function authenticate($email, $password): bool
{
    $user = fetchUser($email);
    if ($user != null && $user["password"] == $password) {
        return true;
    }
    return false;
}


if (!empty($_POST)) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    if (authenticate($email, $password)) {
        header("Location: login.php?logged=true");
    }
    else{
        header("Location: login.php?logged=false");
    }
}


?>
<?php

include "./includes/head.php" ?>

    <main>
        <h1>Login</h1>
        <?php
        if ($registered === "true"): ?>
            <div class="alert alert-success p-0" role="alert">
                Successfully registered!
            </div>
        <?php
        elseif ($registered === "false"): ?>
            <div class="alert alert-danger p-0" role="alert">
                User is already registered!
            </div>
        <?php
        endif; ?>
        <form method="POST" class="m-3" action="<?php
        echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                <input type="password" id="password" class="form-control"
                       name="password"
                       placeholder="Password">
                <?php
                if (isset($errors["password"])): ?>
                    <div class="alert alert-danger p-0" role="alert">
                        <?= $errors["password"] ?>
                    </div>
                <?php
                endif; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
    </main>
<?php
if ($logged === "true"): ?>
    <div class="alert alert-success p-0" role="alert">
        Logged In!
    </div>
<?php
elseif ($logged === "false"): ?>
    <div class="alert alert-danger p-0" role="alert">
        Invalid login details!
    </div>
<?php
endif; ?>
<?php
include "./includes/foot.php" ?>