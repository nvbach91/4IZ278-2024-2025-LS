<?php 
    session_start();
    $product = isset($_GET["id_product"]) ? (int)$_GET["id_product"] : null;
    if (!isset($_SESSION["cart"]) || !isset($_SESSION["cart"][$product])) {
        $_SESSION["deleteFromCartFailed"] = "Tento produkt není v košíku.";
    } else {
        unset($_SESSION["cart"][$product]);
        $_SESSION["deleteFromCartSuccess"] = "Produkt byl úspěšně odstraněn z košíku.";
    }
    header("Location: ../cart.php");
?>