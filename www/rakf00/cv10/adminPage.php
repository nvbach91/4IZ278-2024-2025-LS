<?php
require_once("Database.php");
$users = [];

$authenticated = false;
session_start();
if (isset($_SESSION["email"])) {
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
if (!$authenticated) {

    echo "<h1>User not authenticated</h1>";

}
?>

<?php
if ($_SESSION["privilege"] == "3"): ?>
  <h1>All users</h1>
  <table>
    <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Privilege</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user): ?>
      <tr>
        <td><?= $user["name"] ?></td>
        <td><?= $user["email"] ?></td>
        <td><?= $user["privilege"] ?></td>
      </tr>
    <?php
    endforeach; ?>
    </tbody>
  </table>
<?php
else: ?>
  <?php echo "<h1>Sem nemáte přístup</h1>"?>
<?php
endif; ?>


</body>
</html>
