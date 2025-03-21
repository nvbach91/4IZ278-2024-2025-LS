<?php

function getUsers() {
  $users = [];
  $lines = file('./users.db');
  foreach ($lines as $line) {
    $fields = explode(';', $line);
    $user = [];
    $user['email'] = $fields[0];
    $user['password'] = $fields[1];
    $user['name'] = $fields[2];
    $user['avatar'] = $fields[3];
    array_push($users, $user);
  }
  return $users;
}

function addUser($user) {
  // email, password, name, avatar
  $email = $user['email'];
  $password = $user['password'];
  $name = $user['name'];
  $avatar = $user['avatar'];

  $record = "$email;$password;$name;$avatar";
  file_put_contents('./users.db', PHP_EOL . $record, FILE_APPEND);
}

function getUserByEmail($email) {
  $users = getUsers();
  foreach($users as $user) {
    if ($user['email'] == $email) {
      return $user;
    }
  }
  return null;
}

$isSubmittedForm = !empty($_POST);
if ($isSubmittedForm) {
  $isExistingUser = getUserByEmail($_POST['email']) != null;
  if (!$isExistingUser) {
    addUser([
      'email' => $_POST['email'],
      'password' => $_POST['password'],
      'name' => $_POST['name'],
      'avatar' => $_POST['avatar'],
    ]);
  }
}

$users = getUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>File handling in PHP</h1>
<!--
  123@ccc.com
  password_wow
  Marcelo
  https://encrypted-tbn3.gstatic.com/licensed-image?q=tbn:ANd9GcTunoFN3U3mQt_BK6Lpc0VVU2xie9WsUhoQ0-8MIkm2eIsO6Ay1eCVzbawh9sLwvvP3F4EyOsbYtORPOZA
-->
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div><input placeholder="email" name="email"></div>
    <div><input placeholder="password" name="password"></div>
    <div><input placeholder="name" name="name"></div>
    <div><input placeholder="avatar" name="avatar"></div>
    <button>Submit</button>
  </form>
  <table class="users">
    <thead>
      <tr>
        <th>Email</th>
        <th>Password</th>
        <th>Name</th>
        <th>Avatar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user) : ?>
        <tr>
          <td><?php echo $user['email']; ?></td>
          <td><?php echo $user['password']; ?></td>
          <td><?php echo $user['name']; ?></td>
          <td><img width="100" src="<?php echo $user['avatar']; ?>" alt="avatar"></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>