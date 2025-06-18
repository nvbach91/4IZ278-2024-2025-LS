<?php
    session_start();
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        unset($_SESSION["cart"]);
    }
    $_SESSION["logoutSuccess"] = "Byli jste úspěšně odhlášeni!";
    setcookie("loginSuccess", $name, time(), '/'); 
    header("Location: ../index.php");
    exit;
?>