<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/UserDB.php";
require __DIR__ . "/../utils/validation.php";

$userDB = new UserDB();
$user = $userDB->fetchById($_SESSION['user_id']);

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current'] ?? null;
    $new = $_POST['password'] ?? null;
    $confirm = $_POST['confirm'] ?? null;

    if (!fieldsNotEmpty([$current, $new, $confirm])) {
        $errors[] = "All fields are required.";
    } else {
        if (!password_verify($current, $user['password'])) {
            $errors[] = "Wrong password.";
        }

        if ($new !== $confirm) {
            $errors[] = "The new password and the confirm password do not match.";
        }

        if (strlen($new) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
    }

    if (empty($errors)) {
        $userDB->update($_SESSION['user_id'], [
            'password' => password_hash($new, PASSWORD_DEFAULT)
        ]);
        $successMessage = "Password changed successfully.";
    }
}

require __DIR__ . "/../views/pages/change_password.php";