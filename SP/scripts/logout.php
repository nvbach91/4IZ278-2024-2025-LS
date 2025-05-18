<?php
    session_start();
    $_SESSION["logoutSuccess"] = "Byli jste úspěšně odhlášeni!";
    setcookie('loginSuccess', $name, time(), '/'); 
    header('Location: ../index.php');
    exit;
?>