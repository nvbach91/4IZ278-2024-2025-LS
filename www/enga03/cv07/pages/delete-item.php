<?php
session_start();
require_once __DIR__ . '/../database/DatabaseOperation.php';

if (isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];

    $dbOps = new DatabaseOperation();
    $dbOps->deleteGood($good_id);

    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../index.php');
    exit;
}
?>