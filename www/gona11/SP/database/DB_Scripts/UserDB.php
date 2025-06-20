<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class UserDB extends Database {
    protected $tableName = "user";

    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function checkUserEmail ($email) {
        $sql = "SELECT email FROM $this->tableName WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":email" => $email]);  
        $result = $statement->fetch();
        if(empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function insertUser($name, $surname, $password, $email) {
        $sql = "INSERT INTO $this->tableName (
                    name,
                    surname,
                    password_hash,
                    email,
                    privilege_level) 
                VALUES (
                    :name,
                    :surname,
                    :password,
                    :email,
                    :privilege)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":name" => $name,
            ":surname" => $surname,
            ":password" => $password,
            ":email" => $email,
            ":privilege" => 1
        ]);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":email" => $email
        ]);
        return $statement->fetch();
    }

        public function getUserById($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id_user = :id_user";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id_user" => $id
        ]);
        return $statement->fetch();
    }

    
    public function findByOAuth($provider, $oauthId) {
        $sql = "SELECT * FROM {$this->tableName} WHERE oauth_provider = :provider AND oauth_id = :oauth_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':provider' => $provider,
            ':oauth_id' => $oauthId
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

   public function createOAuth($email, $name, $oauth_provider, $oauth_id) {
        $sql = "INSERT INTO {$this->tableName} (
                    email,
                    name, 
                    privilege_level,
                    oauth_provider,
                    oauth_id
                ) VALUES (
                    :email,
                    :name,
                    :privilege_level,
                    :oauth_provider,
                    :oauth_id
                )";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':email' => $email,
            ':name' => $name,
            ':privilege_level' => 1,
            ':oauth_provider' => $oauth_provider,
            ':oauth_id' => $oauth_id,
        ]);
    } 

    public function editPrivilegeLevel($id, $newPrivilegeLevel) {
        $sql = "UPDATE {$this->tableName} SET privilege_level = :privilege_level WHERE id_user = :id_user";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":privilege_level" => $newPrivilegeLevel,
            ":id_user" => $id
        ]);
    }
}