<?php
require_once __DIR__ . '/database.php';

class UserDB extends Database {
    protected $tableName = 'users';

    public function resetPassword($args) {}
    public function changeAvatar($args) {}
    
    public function fetchUser($email) {
        return $this->findBy('email', $email);
    }
    
    function registerNewUser($payload) {
        if (!empty($this->fetchUser($payload['email']))) {
            return ['success' => false, 'msg' => 'Email already registered. Please use another email address.'];
        }
        
        $passhash = password_hash($payload['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users`(`name`, `email`, `pass`, `privilege`) VALUES (:name, :email, :pass, :privileges)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'email' => $payload['email'],
            'name' => $payload['name'],
            'pass' => $passhash,
            'privileges' => 0
        ]);
        return ['success' => true, 'msg' => 'Registration was successful'];
    }
    
    function authenticate($email, $password) {
        $user = $this->fetchUser($email)[0];
        $isPassCorrect = password_verify($password, $user['pass']);

        if ($user == NULL) {
            return ['success' => false, 'msg' => 'This account does not exist'];
        }
        if (!$isPassCorrect) {
            return ['success' => false, 'msg' => 'Wrong password'];
        }
        session_start();
        $_SESSION['username'] = $user['email'];
        return ['success' => true, 'msg' => 'Login success'];
    }
}