<?php
require "Database.php";

$users = [];

$authenticated = false;
session_start();
if(isset($_SESSION["email"])){
  $authenticated = true;
  $database = new Database();
  $users = $database->fetch([]);
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
} else {
    echo "<h1>User not authenticated</h1>";
}
?>

<?php if($_SESSION["privilege"] == "3"):?>
<table>
    <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Privilege</th>
    </tr>
    </thead>
    <tbody>
<?php foreach ($users as $user): ?>
  <tr>
    <td><?= $user["name"] ?></td>
    <td><?= $user["email"] ?></td>
    <td><?= $user["privilege"] ?></td>
  </tr>
<?php endforeach;?>
    </tbody>
</table>
<?php endif;?>


</body>
</html>
