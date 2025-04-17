<?php
require "Database.php";

$users = [];

$authenticated = false;
session_start();
if(isset($_SESSION["email"])){
  $authenticated = true;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
if ($authenticated) {
    echo "<h1>User <span style='color: brown'>".$_SESSION["email"] . "</span> authenticated</h1>";
    require_once "navbar.php";
} else {
    echo "<h1>User not authenticated</h1>";
    sleep(2);
    header("Location: login.php");
}
?>

</body>
</html>
