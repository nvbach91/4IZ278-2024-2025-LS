<?php
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/UsersDB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
$current_user = $usersDB->getUserById($_SESSION['id']);

if (!$current_user || $current_user['role'] !== 'admin') {
    session_destroy();
    header('Location: ./../index.php');
    exit;
}