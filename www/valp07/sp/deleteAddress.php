<?php
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/UsersDB.php';

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);

$usersDB->updateAddressId($_SESSION['id'], null);

header('Location: profile.php');
exit;
