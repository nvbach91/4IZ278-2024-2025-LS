<?php
require __DIR__ . '/../config/config.php';
function fetchUsers()
{
    $users = [];
    $lines = file(DB_FILE_USERS);
    foreach ($lines as $line) {
        $fields = explode('   ', $line);
        $user = [
            'email' => $fields[0],
            'name' => $fields[1],
            'password' => $fields[2],
        ];
        array_push($users, $user);
    }
    return $users;
}

$users = fetchUsers();

function registerNewUser($password, $name, $email)
{
    $isExistingUser = fetchUser($email) !== null;
    if ($isExistingUser) {
        return null;
    } else {
        $record = "$email   $name   $password";
        file_put_contents(DB_FILE_USERS, $record . PHP_EOL, FILE_APPEND);
        return true;
    }
}
function fetchUser($email)
{
    $users = fetchUsers();
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            return $user;
        }
    }
    return null;
}
?>