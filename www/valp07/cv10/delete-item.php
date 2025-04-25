<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
require 'db/UsersDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
if (!isset($_SESSION['user_email'])||$usersDB->checkUserPrivilege($_SESSION['user_email'])<2) {
    header('Location: login.php');
    exit();
}
// Get and validate the item ID
$good_id = filter_input(INPUT_GET, 'good_id', FILTER_VALIDATE_INT);
if (!$good_id) {
    header('Location: index.php');
    exit();
}

// Verify the item exists before attempting to delete
$itemDB = new ProductsDB($connection);
$item = $itemDB->findProductByID($good_id);
if ($item) {
    $itemDB->delete($good_id);

}



// Redirect back to index
header('Location: index.php');
exit();
?>
