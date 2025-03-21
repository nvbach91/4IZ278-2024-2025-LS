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
  // READ existing record(s)
  $sql = "SELECT * FROM Users;";
  $users = $connection->query($sql)->fetchAll();
  // INSERT new record(s)
  $sql = "INSERT INTO Users VALUES ('', '', '') ";
  // UPDATE existing record(s)
  $sql = "UPDATE TABLE Users ...";
  // DELETE existing records(s)
  $sql = "DELETE ...";

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