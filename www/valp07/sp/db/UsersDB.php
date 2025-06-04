<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class UsersDB extends Database
{
    protected $tableName = 'users';
    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM $this->tableName WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($args)
    {
        $sql = "INSERT INTO $this->tableName (name, email, password_hash, role) VALUES (:name, :email, :password, 'user')";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $args['password'],
        ]);
    }
    public function getAllUsers()
    {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updatePassword(int $userId, string $newHash): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
        $stmt->execute(['hash' => $newHash, 'id' => $userId]);
    }
    public function getUserById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
    public function resetPassword($id)
    {

        $token = bin2hex(random_bytes(16));

        $sql = "UPDATE $this->tableName SET reset_token = :token WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'token' => $token,
            'id' => $id
        ]);
        $resetLink = "https://eso.vse.cz/~valp07/sp/resetPassword.php?token=$token";
        return $resetLink;
    }
    public function changeRole($id, $role)
    {
        $sql = "UPDATE $this->tableName SET role = :role WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['role' => $role, 'id' => $id]);
    }
    public function findAll()
    {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>