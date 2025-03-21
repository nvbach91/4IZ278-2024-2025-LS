<?php

function fetchUsers($file='users.db') {
    $users = [];

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $parts = explode(";", $line);
        if (count($parts) >= 3) {
            list($userName, $userEmail, $passwordHash) = $parts;
            $users[$userEmail] = [
                'name' => $userName,
                'email' => $userEmail,
                'password' => $passwordHash
            ];
        }
    }
    
    return $users;
}


function fetchUser($email) {
    $users = fetchUsers();
    return $users[$email] ?? null;
}


function registerNewUser($name, $email, $password) {
    $file = 'users.db';
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $record = $name . ";" . $email . ";" . $passwordHash . "\n";
    return file_put_contents($file, $record, FILE_APPEND | LOCK_EX) !== false;
}

function authenticate($email,$password) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $user = fetchUser($email);
    if (empty($user)) {
        return null;
    }

    if (password_verify($password,$user['password'])) {
        return true;
    } else {
        return false;
    }
}
?>