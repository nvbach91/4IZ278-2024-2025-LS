<?php

function fetchUsers() {
    $users = [];
    $lines = file('./users.db');
    foreach($lines as $line) {
        $fields = explode(';',$line);
        $user = [];
        $user['name'] = $fields[0];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}


function fetchUser($email) {
    $users = fetchUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}


function registerNewUser($name, $email, $password) {

    if (fetchUser($email) !== null) {
        return false;
    }

    $record = PHP_EOL . "$name;$email;$password";
    file_put_contents('./users.db', $record, FILE_APPEND);

    $subject = 'Registration Successful';
    $message = 'You have successfully registered.';
    $header = 'From: veji03@vse.cz';

    mail($email, $subject, $message, $header);
}

function authenticate($email, $password) {
    $user = fetchUser ($email);
    if ($user === null) {
        return 'email';
    }
    if ($user['password'] !== $password) {
        return 'password';
    }
    return 'success';
}

?>
