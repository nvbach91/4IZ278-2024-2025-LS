<?php
function fetchUser($email)
{
    $file = fopen(__DIR__ . "/../data/users.db", "r");
    while (!feof($file)) {
        $line = fgets($file);
        $fields = explode(";", $line);
        if ($fields[2] == $email) {
            $user = [];
            $user["name"] = $fields[0];
            $user["lastName"] = $fields[1];
            $user["email"] = $fields[2];
            $user["password"] = rtrim($fields[3]);
            fclose($file);
            return $user;
        }
    }
    fclose($file);
    return null;
}
function fetchUsers()
{
    $file = fopen(__DIR__ . "/../data/users.db", "r");
    $users = [];
    while (!feof($file)) {
        $line = fgets($file);
        $fields = explode(";", $line);
        $user = [];
        $user["name"] = $fields[0];
        $user["lastName"] = $fields[1];
        $user["email"] = $fields[2];
        $user["password"] = $fields[3];
        $users[$fields[2]] = $user;
    }
    return $users;
}


function registerNewUser($user)
{
    $users = fetchUsers();
    if (array_key_exists($user['email'], $users)) {
        return null;
    }
    $name = $user['name'];
    $lastName = $user['lastName'];
    $email = $user['email'];
    $password = $user['password'];
    $record = "$name;$lastName;$email;$password";
    file_put_contents(__DIR__ . "/../data/users.db", PHP_EOL .  $record, FILE_APPEND);
    return 0;
}
