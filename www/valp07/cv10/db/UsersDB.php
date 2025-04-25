<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class UsersDB extends Database {
    protected $tableName = 'cv07_users';
    public function findUserByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function checkUserPrivilege($email) {
        $sql = "SELECT privilege FROM $this->tableName WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['privilege'] : null;
    }
    public function create($args) {
        $sql = "INSERT INTO $this->tableName (email, password, privilege) VALUES (:email, :password, 1)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'email' => $args['email'], 
            'password' => $args['password'], 
        ]);
        
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateUserPrivileges($userId, $privilege) {
        $sql = "UPDATE $this->tableName SET privilege = :privilege WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'privilege' => $privilege,
            'user_id' => $userId,
        ]);
    }
}

?>