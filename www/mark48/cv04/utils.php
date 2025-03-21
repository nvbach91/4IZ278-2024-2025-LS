<?php
require_once "classes/User.php";


function fetchUser($email)
{
    $lines = file('users.db')
        or die('Cannot read file');
    foreach ($lines as $line) {
        $user_data = explode(';', $line);
        if ($user_data[1] === $email) {
            return new User($user_data[0], $user_data[1], str_replace(array("\r", "\n"), '', $user_data[2]));
        }
    }
}

function fetchUsers()
{
    $lines = file('users.db')
        or die('Cannot read file');
    $users = [];
    foreach ($lines as $line) {
        $user_data = explode(';', $line);
        $user = new User($user_data[0], $user_data[1], str_replace(array("\r", "\n"), '', $user_data[2]));
        array_push($users, $user);
    }
    return $users;
}

function registerUser($name, $email, $password)
{
    $user = new User($name, $email, $password);

    if (fetchUser($email) === null) {
        $line = $user->formatToCsv() . PHP_EOL;
        file_put_contents('users.db', $line, FILE_APPEND);
        mail($email, 'Registration successful', 'Welcome to our website');
        return true;
    } else {
        return false;
    }
}
