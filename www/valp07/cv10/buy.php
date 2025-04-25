<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
require 'db/UsersDB.php';
session_start();
$connection = DatabaseConnection::getPDOConnection();
$productsDB = new ProductsDB($connection);
$usersDB = new UsersDB($connection);
if (!isset($_SESSION['user_email']) || $usersDB->checkUserPrivilege($_SESSION['user_email']) < 1) {
    header('Location: login.php');
    exit();
}
# session pole pro kosik
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$productsDB->findProductByID($_GET['good_id']);
if (!isset($_SESSION['user_email']) || $usersDB->checkUserPrivilege($_SESSION['user_email']) < 1) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM cv07_goods WHERE good_id = :id";
$stmt = $connection->prepare($sql);
$stmt->execute(['id' => $_GET['good_id']]);
$goods = $stmt->fetch();

if (!$goods) {
    exit("Unable to find goods!");
}

# pridame id zbozi do session pole
# TODO neresime, ze od jednoho zbozi muze byt vetsi mnozstvi nez 1, domaci ukol :)
$_SESSION['cart'][] = $goods["good_id"];
header('Location: cart.php');
exit();
?>