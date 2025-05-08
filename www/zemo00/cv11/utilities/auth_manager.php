<?php

session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['privilege'], [2, 3])){
    $_SESSION['flash_message'] = "Access denied. You don't have permission to view that page.";
    header('Location: home.php');
    exit;
}

?>