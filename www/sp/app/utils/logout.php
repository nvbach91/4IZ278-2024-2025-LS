<?php
session_start();
session_unset();
session_destroy();
$url = BASE_URL . "/login.php";
header("Location:  $url");
exit;
?>