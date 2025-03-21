<?php
require __DIR__ . "/fileHandling.php";

$sucess;
$errors = [];
if (empty($_POST)) {
    return;
}

$email = htmlspecialchars(trim($_POST["email"]));
$fullName = htmlspecialchars(trim($_POST["fullName"]));
$password = htmlspecialchars(trim($_POST["password"]));
$confirm = htmlspecialchars(trim($_POST["confirm"]));

//validation

if (empty($fullName)) {
    $errors["fullName"] = "Full name is required";
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email is not valid";
}

if (!is_null(fetchUser($email))) {
    $errors["email"] = "Account with this email address has already been registred";
}

if (strlen($password) < 8) {
    $errors["password"] = "Password is not valid";
}

if ($password !== $confirm) {
    $errors["confirm"] = "Passwords do not match";
}

if (empty($errors)) {
    registerNewUser([
        "name" => $fullName,
        "email" => $email,
        "password" => $password,
    ]);

    $success = "User has been successfully registered";
    mail($email, "Registration", "You have been successfully registered");
    header('Location: ' . "login.php?email=".$_POST["email"]);
}
