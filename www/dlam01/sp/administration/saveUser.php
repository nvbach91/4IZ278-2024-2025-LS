<?php

session_start();
require_once __DIR__ . '/../database/UsersDB.php';

if ($_SESSION['privilege'] < '3') {
    header("Location: ../index.php");
    exit;
}

$usersDB = new UsersDB();
$errors = [];

if (!isset($_GET["id"])) {
    header("Location: ../index.php");
    exit;
}

$userId = $_GET["id"];
$user = $usersDB->fetchById($userId);
if (!$user) {
    header("Location: ../index.php");
    exit;
}
if (!empty($_POST)) {
    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $secondName = htmlspecialchars(trim($_POST["secondName"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $privilege = htmlspecialchars(trim($_POST["privilege"]));

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

    if (!in_array($privilege, [1, 2, 3])) {
        $errors["privilege"] = "Privilege must be set to 1, 2, or 3.";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: editUser.php?id=" . urlencode($userId));
    } else {
        $usersDB->update($userId, $firstName, $secondName, $email, $password, $privilege);
        $_SESSION["success"] = "User updated successfully.";
        header("Location: adminUsers.php");
    }
}
