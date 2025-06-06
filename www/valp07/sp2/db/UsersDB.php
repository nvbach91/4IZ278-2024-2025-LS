<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class UsersDB extends Database {
    protected $tableName = 'users';
    public function findUserByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($args) {
        $sql = "INSERT INTO $this->tableName (email, password_hash, role) VALUES (:email, :password, 'user')";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'],
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
    public function getUserById($id) {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    

}

?>