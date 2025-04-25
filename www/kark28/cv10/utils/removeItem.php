<?php
session_start();
if(!isset($_SESSION['name'])) {
    header('Location: /login.php');
    exit();
  }
$id = @$_POST['id'];
foreach ($_SESSION['cart'] as $key => $value){
    if ($value == $id) {
        unset($_SESSION['cart'][$key]);
    }
}
header('Location: ../cart.php');
exit();
?>