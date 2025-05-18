<?php require_once __DIR__ . '/../Database.php'?>
<?php 

class UserDB extends Database {
    protected $tableName = 'user';

    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function checkUserEmail ($email) {
        $sql = "SELECT email FROM $this->tableName WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':email' => $email]);  
        $result = $statement->fetch();
        if(empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function insertUser($name, $surname, $password, $email) {
        $sql = "INSERT INTO $this->tableName (name, surname, password_hash, email, privilege_level) VALUES (:name, :surname, :password, :email, :privilege)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':name' => $name,
            ':surname' => $surname,
            ':password' => $password,
            ':email' => $email,
            ':privilege' => 1
        ]);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':email' => $email]);
        return $statement->fetch();
    }
}