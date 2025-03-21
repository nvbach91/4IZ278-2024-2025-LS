<?php


function fetchUsers(){
    $users = [];
    $lines = file('./users.db');
    foreach($lines as $line){
        $fields = explode(';', trim($line));
        $users[$fields[0]] = [$fields[1], $fields[2]];
    }
    return $users;
}

function fetchUser($email){
    $lines = file('./users.db');
    foreach($lines as $line){
        $fields = explode(';', trim($line));
        if($fields[0] == $email) {
            $user = [
                'email' => $fields[0],
                'password' => $fields[1],
                'username' => $fields[2]
            ];
            return $user;
        }
    }
    return null;
}

function doesPasswordMatch($email, $password){
    $users = fetchUsers();
    foreach($users as $key => $value){
        if($key == $email){
            if($value[0] == $password){
                return true;
            }
        }
    }
    return false;
}

function registerNewUser($user){
    $email = $user['email'];
    if(!authenticate($email)){
        $password = $user['password'];
        $username = $user['username'];

        $record = "$email;$password;$username" . PHP_EOL;
        file_put_contents("./users.db", $record, FILE_APPEND);

        return true;
    } else{
        return false;
    }

}


function authenticate($email){
    $user = fetchUser($email);
    if($user == null){
        return false;
    }
    return true;
}


?>