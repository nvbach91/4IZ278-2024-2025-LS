<?php

function fetchUsers() {
    $users = [];
    $filename = __DIR__ . '/users.db';
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode(";", $line);
            if(count($data) >= 3) {
                $name = trim($data[0]);
                $email = trim($data[1]);
                $password = trim($data[2]);
                $users[$email] = ['name' => $name, 'email' => $email, 'password' => $password];
            }
        }
    }
    return $users;
}

function fetchUser($email) {
    $users = fetchUsers();
    if(isset($users[$email])) {
        return $users[$email];
    }
    return null;
}

function registerNewUser($name, $email, $password) {
    $users = fetchUsers();
    if(isset($users[$email])) {
        return ['success' => false, 'message' => 'Uživatel s tímto e-mailem již existuje.'];
    }
    $record = $name . ";" . $email . ";" . $password . "\n";
    $filename = 'users.db';
    if(file_put_contents($filename, $record, FILE_APPEND | LOCK_EX) === false) {
        return ['success' => false, 'message' => 'Chyba při ukládání dat.'];
    }
    $subject = "Registrace proběhla úspěšně";
    $message = "Děkujeme za registraci, " . $name . ".";
    $headers = "From: no-reply@vse.cz";
    mail($email, $subject, $message, $headers);
    return ['success' => true, 'message' => 'Registrace byla úspěšná.'];
}

function authenticate($email, $password) {
    $user = fetchUser($email);
    if(!$user) {
        return ['success' => false, 'message' => 'Uživatel s tímto e-mailem neexistuje.'];
    }
    if($user['password'] !== $password) {
        return ['success' => false, 'message' => 'Špatné heslo.'];
    }
    return ['success' => true, 'message' => 'Přihlášení proběhlo úspěšně.'];
}
?>
