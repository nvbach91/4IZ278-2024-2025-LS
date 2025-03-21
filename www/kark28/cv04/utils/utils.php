<?php 
require __DIR__ . '/../config/config.php';

function fetchUsers() {
    $users = [];
    $lines = file(DB_FILE_USERS);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue;
        $fields = explode(DELIMITER, $line);
        $users[$fields[1]] = [
            'name' => $fields[0],
            'email' => $fields[1],
            'pass' => $fields[2],
        ];
    }
    return $users;
};

function fetchUser($email) {
    $lines = file(DB_FILE_USERS);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue; // skip blank lines
        $fields = explode(DELIMITER, $line);
        if ($fields[1] === $email) {
            return [
                'name' => $fields[0],
                'email' => $fields[1],
                'pass' => $fields[2],
            ];
        }
    }
    return null;
};

function registerNewUser($payload) {
    $users = fetchUsers();
    if (array_key_exists($payload['email'], $users)) {
        return ['success' => false, 'msg' => 'Email already registered. Please use another email address.'];
    }
    $userRecord = 
        $payload['name'] . DELIMITER .
        $payload['email'] . DELIMITER .
        $payload['pass'] . "\r\n";
    file_put_contents(DB_FILE_USERS, $userRecord, FILE_APPEND);
    return ['success' => true, 'msg' => 'Registration was successful'];
};

function authenticate($email, $password) {
    $user = fetchUser($email);
    if (!$user) {
        return ['success' => false, 'msg' => 'This account does not exist'];
    }
    if ($user['pass'] !== $password) {
        return ['success' => false, 'msg' => 'Wrong password'];
    }
    return ['success' => true, 'msg' => 'Login success'];
};