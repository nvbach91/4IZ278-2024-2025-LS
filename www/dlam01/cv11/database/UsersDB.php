<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class UsersDB extends Database
{
    protected $tableName = 'users';

    public function fetchByEmail($email)
    {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($email, $password, $privilege)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tableName (email, password, privilege) VALUES (:email, :password, :privilege);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        $statement->bindValue(':privilege', (int)$privilege, PDO::PARAM_INT);
        $statement->execute();
    }

    public function fetchById($Id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :Id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':Id', (int)$Id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $email, $password, $privilege){
        $sql = "UPDATE $this->tableName SET email = :email, password = :password, privilege = :privilege WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $statement->bindValue(':privilege', (int)$privilege, PDO::PARAM_INT);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $statement->execute();
    }
}
?>