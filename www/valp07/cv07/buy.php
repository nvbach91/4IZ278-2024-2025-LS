<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
session_start();

# session pole pro kosik
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$connection = DatabaseConnection::getPDOConnection();

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