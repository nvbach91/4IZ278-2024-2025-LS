<?php
require __DIR__ . "/fileHandling.php";

$success;
$errors = [];

if (!empty($_GET["email"])) {
    $email = $_GET["email"];
    $success = "Your account has been successfully registered, you can now log in.";
}

if (empty($_POST)) {
    return;
}

$email = htmlspecialchars(trim($_POST["email"]));
$password = htmlspecialchars(trim($_POST["password"]));

if (is_null(fetchUser($email))) {
    $errors["email"] = "Email was not registered";
} elseif (!(fetchUser($email)["password"] == $password)) {
    $errors["password"] = "Password is not valid";
}

if (empty($errors)) {
    $success = "Welcome " . fetchUser($email)["name"] . ", you have successfully logged in.";
}
