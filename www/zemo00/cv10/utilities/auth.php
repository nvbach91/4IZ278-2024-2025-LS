<?php

session_start();
if (!isset($_SESSION['user_id'])){
    $_SESSION['flash_message'] = "You need to log in.";
    header('Location: index.php');
    exit;
}

?>