<?php

session_start();
if ($_SESSION['privilege'] < '3') {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../database/UsersDB.php';
$usersDB = new UsersDB();

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

$usersDB->deleteById($userId);
header("Location: adminUsers.php");
exit;
?>