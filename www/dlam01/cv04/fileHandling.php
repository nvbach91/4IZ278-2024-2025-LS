<?php
function fetchUsers()
{
    $users  = [];
    $lines = file(__DIR__ . "/users.db");
    foreach ($lines as $line) {
        $fields = explode(";", $line);
        $user = [
            "name" => $fields[0],
            "email" => $fields[1],
            "password" => $fields[2],
        ];
        array_push($users, $user);
    }
    return $users;
}

function registerNewUser($user)
{
    $line = $user["name"] . ";" . $user["email"] . ";" . $user["password"] . ";";
    file_put_contents(__DIR__ . "/users.db", PHP_EOL . $line, FILE_APPEND);
}

function fetchUser($email)
{
    $users = fetchUsers();
    foreach ($users as $user) {
        if ($user["email"] === $email) {
            return $user;
        }
    }
    return null;
}
