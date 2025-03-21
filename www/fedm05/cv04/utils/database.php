<?php

define('DB_FILE', __DIR__ . '/../database/users.db');

function fetchUsers()
{
    $content = file_get_contents(DB_FILE);
    if (empty($content)) {
        return [];
    }

    $lines = explode("\n", $content);
    $users = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            continue;
        }
        $userData = explode('|', $line);
        $users[] = [
            'name' => $userData[0],
            'email' => $userData[1],
            'password' => $userData[2]
        ];
    }

    return $users;
}

// get user by email
function fetchUser($email)
{
    $users = fetchUsers();

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }

    return null;
}

function registerNewUser($name, $email, $password)
{
    // check if user already exists
    if (fetchUser($email) !== null) {
        return false;
    }
    // new user row
    $userData = "$name|$email|$password\n";
    // check if file_put_contents was successful
    return file_put_contents(DB_FILE, $userData, FILE_APPEND) !== false;
}

function authenticate($email, $password)
{
    $user = fetchUser($email);

    if ($user === null) {
        return [false, "User with this email does not exist"];
    }

    if (password_verify($password, $user['password'])) {
        return [true, "Login successful"];
    } else {
        return [false, "Incorrect password"];
    }
}
