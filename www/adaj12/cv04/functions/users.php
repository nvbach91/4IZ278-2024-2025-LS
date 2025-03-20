<?php
function fetchUsers() {
    $users = [];
    if (file_exists(__DIR__ . '/../users.db')) {
        $file = fopen(__DIR__ . '/../users.db', 'r');
        while (($line = fgetcsv($file, 0, ";")) !== FALSE) {
            $users[] = $line;
        }
        fclose($file);
    }
    return $users;
}

function fetchUser($email) {
    $users = fetchUsers();
    foreach ($users as $user) {
        if ($user[0] === $email) {
            return $user;
        }
    }
    return null;
}
?>