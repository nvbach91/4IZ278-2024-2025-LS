<?php require_once __DIR__.'/Database.php';?>
<?php

class UsersDB extends Database {
    protected $tableName = 'eshop_users'; 

    public function addUser($name, $email, $phone, $address, $password) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tableName (name, email, phone, address, password) VALUES (:username, :email, :phone, :address, :password);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['username' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'password' => $hashPassword]);
    }
    
    public function addUserWithPrivilege($name, $email, $phone, $address, $password, $privilege) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tableName (name, email, phone, address, password, privilege) VALUES (:username, :email, :phone, :address, :password, :privilege);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['username' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'password' => $passwordHash, 'privilege' => $privilege]);
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

    public function updateUser($userId, $name, $address, $phone) {
        $sql = "UPDATE $this->tableName SET name = :name, address = :address, phone = :phone WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['name' => $name, 'address' => $address, 'phone' => $phone, 'id' => $userId]);
    }

    public function updatePrivilege($userId, $privilege) {
        $sql = "UPDATE $this->tableName SET privilege = :privilege WHERE user_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['privilege' => $privilege, 'id' => $userId]);
    }

    
}

?>