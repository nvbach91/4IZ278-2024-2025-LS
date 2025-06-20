<?php require_once __DIR__.'/Database.php';?>
<?php

class UsersDB extends Database {
    protected $tableName = 'sp_eshop_users'; 
    
    public function getTableName() {
        return $this->tableName;
    }

    public function addUser($name, $email, $phone, $address, $password, $privilege) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tableName (name, email, phone, address, password, privilege) VALUES (:username, :email, :phone, :address, :password, :privilege);";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['username' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'password' => $passwordHash, 'privilege' => $privilege]);
        return $this->connection->lastInsertId();
    }

    public function addUserFromGoogle($name, $email, $privilege) {
        $sql = "INSERT INTO $this->tableName (name, email, privilege) VALUES (:name, :email, :privilege);";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['name' => $name, 'email' => $email, 'privilege' => $privilege]);
        return $this->connection->lastInsertId();
    }

    public function fetchUsersByPrivilege($privilege) {
        $sql = "SELECT * FROM $this->tableName WHERE privilege = :privilege;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['privilege' => $privilege]);
        return $statement->fetchAll();
    }

    public function fetchUserByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }

    public function fetchUserById($userId) {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $userId]);
        return $statement->fetch();
    }

    public function fetchUserPrivilege($userId) {
        $sql = "SELECT privilege FROM $this->tableName WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $userId]);
        return $statement->fetchColumn();
    }

    public function updateUser($userId, $name, $phone, $address) {
        $sql = "UPDATE $this->tableName SET name = :name, address = :address, phone = :phone WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['name' => $name, 'address' => $address, 'phone' => $phone, 'id' => $userId]);
    }

    public function updatePrivilege($userId, $privilege) {
        $sql = "UPDATE $this->tableName SET privilege = :privilege WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['privilege' => $privilege, 'id' => $userId]);
    }

    public function updateUserPassword($userId, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE $this->tableName SET password = :password WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['password' => $passwordHash, 'id' => $userId]);
    }

    

    
}

?>