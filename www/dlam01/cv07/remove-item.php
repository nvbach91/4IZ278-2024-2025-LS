<?php
session_start();
if(isset($_GET["position"])){
    $position = $_GET["position"];
    if(isset($_SESSION["cart"][$position])){
        unset($_SESSION["cart"][$position]);
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
    }
}
header("Location: cart.php");
exit;
?>