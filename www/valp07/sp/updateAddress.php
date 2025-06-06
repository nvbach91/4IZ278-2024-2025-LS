<?php
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/AddressesDB.php';

session_start();
$connection = DatabaseConnection::getPDOConnection();
$addressesDB = new AddressesDB($connection);
$userId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $addressesDB->saveOrUpdateUserAddress($userId, [
            'address1' => $_POST['address1'],
            'address2' => $_POST['address2'],
            'address3' => $_POST['address3'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'county' => $_POST['county'],
            'postal_code' => $_POST['postal_code']
        ]);
    } elseif ($_POST['action'] === 'delete') {
    }
}

header('Location: profile.php');
exit;
