<?php
    session_start();
    $_SESSION["logoutSuccess"] = "You were successfully logged out.";
    setcookie('loginSuccess', $name, time(), '/'); 
    header('Location: ./index.php');
    exit;
?>