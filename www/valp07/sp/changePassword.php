<?php
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/UsersDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    die('You must be logged in.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        die('New passwords do not match.');
    }

    $user = $usersDB->getUserById($userId);
    if (!$user || !password_verify($old, $user['password_hash'])) {
        die('Old password is incorrect.');
    }

    $newHash = password_hash($new, PASSWORD_DEFAULT);
    $usersDB->updatePassword($userId, $newHash);

    echo 'Password changed successfully.';
}
