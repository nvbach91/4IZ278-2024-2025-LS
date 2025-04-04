<?php
require_once __DIR__ . '/database.php';

class UserDB extends Database {
    protected $tableName = 'users';

    public function resetPassword($args) {}
    public function changeAvatar($args) {}
    
    public function fetchUser($email) {
        
    }
    
    function registerNewUser($payload) {
       /* $users = fetchUsers();
        if (array_key_exists($payload['email'], $users)) {
            return ['success' => false, 'msg' => 'Email already registered. Please use another email address.'];
        }
        $userRecord = 
            $payload['name'] . DELIMITER .
            $payload['email'] . DELIMITER .
            $payload['pass'] . "\r\n";
        file_put_contents(DB_FILE_USERS, $userRecord, FILE_APPEND);
        return ['success' => true, 'msg' => 'Registration was successful'];*/
    }
    
    function authenticate($email, $password) {
       /* $user = fetchUser($email);
        if (!$user) {
            return ['success' => false, 'msg' => 'This account does not exist'];
        }
        if ($user['pass'] !== $password) {
            return ['success' => false, 'msg' => 'Wrong password'];
        }*/
        return ['success' => true, 'msg' => 'Login success'];
    }
}