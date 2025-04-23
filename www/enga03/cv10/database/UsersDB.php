<?php
require_once __DIR__ . '/database-config.php';

class UsersDB {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create($args) {
        $sql = "
            INSERT INTO cv10_users (email, password, name, privilege)
            VALUES (:email, :password, :name, :privilege)
        ";

        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $args['email'],
            'password' => $passwordHash,
            'name' => $args['name'],
            'privilege' => $args['privilege']
        ]);
    }

    public function findOneByEmail($email) {
        $sql = "SELECT * FROM cv10_users WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }
}
?>