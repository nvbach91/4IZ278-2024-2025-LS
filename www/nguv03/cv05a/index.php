<?php
const DB_SERVER_URL = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_DATABASE = 'cv05';

try {
  $connection = new PDO(
    'mysql:host=' . DB_SERVER_URL . ';dbname=' . DB_DATABASE,
    DB_USERNAME,
    DB_PASSWORD,
  );
  $connection->setAttribute(
    PDO::ATTR_DEFAULT_FETCH_MODE,
    PDO::FETCH_ASSOC,
  );
  $sql = "SELECT * FROM Users;";
  $users = $connection->query($sql)->fetchAll();
  var_dump($users);
} catch (PDOException $e) {
  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>PHP PDO Database connection</h1>
</body>

</html>