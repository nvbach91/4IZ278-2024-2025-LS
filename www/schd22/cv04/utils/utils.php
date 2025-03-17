<?php

require __DIR__ . '/../config/config.php';

function fetchUsers() {
    $users = [];
    $lines = file(DB_FILE);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue; // skip blank lines
        $fields = explode(DELIMITER, $line);
        $users[$fields[1]] = [
            'name' => $fields[0],
            'email' => $fields[1],
            'password' => $fields[2],
        ];
    }
    return $users;
};

// Funkce pro načtení jednoho uživatele podle e-mailu
function fetchUser($email) {
    $users = fetchUsers();
    return $users[$email] ?? null;
}

// Funkce pro uložení nového uživatele
function registerNewUser($payload) {
    $users = fetchUsers();
    if (array_key_exists($payload['email'], $users)) {
        return ['success' => false, 'msg' => 'Email already registered. Please use another email address.'];
    }
    $userRecord = 
        $payload['name'] . DELIMITER .
        $payload['email'] . DELIMITER .
        $payload['password'] . "\r\n";
    //echo $userRecord;
    file_put_contents(DB_FILE, $userRecord, FILE_APPEND);
    return ['success' => true, 'msg' => 'Registration was successful'];
};

function authenticate($email, $password) {
    $user = fetchUser($email);
    if (!$user) {
        return ['success' => false, 'msg' => 'This account does not exist'];
    }
    if ($user['password'] !== $password) {
        return ['success' => false, 'msg' => 'Wrong password'];
    }
    return ['success' => true, 'msg' => 'Login success'];
};
?>
