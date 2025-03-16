<?php 
function fetchUsers () {
    $users = [];
    $lines = file('./users.db'); 
    foreach($lines as $line) {
        $fields = explode(';', $line);
        $user = [];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

function fetchUsersDisplay () {
    $users = [];
    $lines = file('../users.db'); 
    foreach($lines as $line) {
        $fields = explode(';', $line);
        $user = [];
        $user['name'] = $fields[0];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

function checkExistingUser($email) {
    $users = fetchUsers();
    foreach($users as $user) {
                if($user['email'] == $email) {
                    return true;
                }
            }
    return false;
}

function getUserPassword($email) {
    $users = fetchUsers();
    $password = '';
    foreach($users as $user) {
        if($user['email'] == $email) {
            $password = $user['password'];
            return $password;
        }
    }
    return $password;
}

function registerNewUser ($user) {
    $email = $user['email'];
    $password = $user['password'];
    $name = $user['name'];
    $record = "$name;$email;$password";
    file_put_contents('./users.db', PHP_EOL . $record, FILE_APPEND);
}

?>