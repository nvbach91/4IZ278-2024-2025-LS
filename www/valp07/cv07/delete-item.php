<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();

// Get and validate the item ID
$good_id = filter_input(INPUT_GET, 'good_id', FILTER_VALIDATE_INT);
if (!$good_id) {
    header('Location: index.php');
    exit();
}

// Verify the item exists before attempting to delete
$sql = "SELECT good_id FROM cv07_goods WHERE good_id = :good_id";
$stmt = $connection->prepare($sql);
$stmt->execute(['good_id' => $good_id]);
$item = $stmt->fetch();

if ($item) {
    // Delete the item
    $sql = "DELETE FROM cv07_goods WHERE good_id = :good_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['good_id' => $good_id]);
}

// Redirect back to index
header('Location: index.php');
exit();
?>
