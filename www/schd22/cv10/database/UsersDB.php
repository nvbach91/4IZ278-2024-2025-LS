<?php require_once 'Database.php'; ?>
<?php
class UsersDB extends Database {
    protected $tableName = 'cv10_users';
    
    public function create($args) {
        $sql = "INSERT INTO $this->tableName (email, password, name, privilege) VALUES (:email, :password, :name, :privilege)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'email' => $args['email'],
            'password' => $args['password'],
            'name' => $args['name'],
            'privilege' => $args['privilege'],
        ]);
    }

    public function findOneByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }

    public function setPrivilege($email, $privilege) {
        $sql = "UPDATE $this->tableName SET privilege = :privilege WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'email' => $email,
            'privilege' => $privilege,
        ]);
    }

    public function getPrivilege($email) {
        $sql = "SELECT privilege FROM $this->tableName WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetchColumn();
    }
    public function findAll() {
        $query = "SELECT * FROM cv10_users"; // název tabulky podle tebe
        return $this->connection->query($query)->fetchAll();
    }
    
    public function updatePrivilege($userId, $privilege) {
        $stmt = $this->connection->prepare("UPDATE cv10_users SET privilege = :privilege WHERE user_id = :user_id");
        $stmt->execute([
            'privilege' => $privilege,
            'user_id' => $userId
        ]);
    }

    public function deleteById($userId) {
        $stmt = $this->connection->prepare("DELETE FROM cv10_users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
}

?>