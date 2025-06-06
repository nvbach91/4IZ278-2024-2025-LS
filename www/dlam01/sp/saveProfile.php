<?php

session_start();
require_once __DIR__ . '/database/UsersDB.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$usersDB = new UsersDB();
$errors = [];

$user = $usersDB->fetchById($_SESSION['user_id']);
if (!$user) {
    header("Location: /index.php");
    exit;
}
if (!empty($_POST)) {
    $userId = $_SESSION['user_id'];
    $firstName = trim($_POST["firstName"]);
    $secondName = trim($_POST["secondName"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($firstName)) {
        $errors["firstName"] = "First name is required.";
    }

    if (empty($secondName)) {
        $errors["secondName"] = "Second name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format.";
    }

    if (strlen($password) > 0 && strlen($password) < 8) {
        $errors["password"] = "Password must be at least 8 characters long.";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: profile-information.php");
    } else {
        $usersDB->update($userId, $firstName, $secondName, $email, $password, $user["privilege"]);
        $_SESSION["success"] = "User updated successfully.";
        $_SESSION["userTEST"] = $user;
        unset($_SESSION["email"]);
        $_SESSION["email"] = $email;
        header("Location: profile-information.php");
    }
}
