<?php require_once __DIR__ . '/Database.php'?>
<?php 

class UsersDB extends Database {
    protected $tableName = 'users';

    public function insertUser($name, $email, $password, $privilege) {
        $sql = "INSERT INTO $this->tableName (email, password, name, privilege) VALUES (:email, :password, :name, :privilege)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':email'=>$email,
            ':password'=>$password,
            ':name'=>$name,
            ':privilege'=>$privilege
        ]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':email' => $email
        ]);
        return $statement->fetch();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function updateUserPrivilege($id, $privilege) {
        $sql = "UPDATE $this->tableName SET `privilege` = :privilege WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':privilege' => $privilege,
            ':id' => $id
        ]);
    }
}

?>