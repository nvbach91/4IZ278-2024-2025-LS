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
        $resetLink = 'https://eso.vse.cz/~valp07/sp/resetPassword.php?token=' . urlencode($token);
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
    public function findUserByResetToken($token)
    {
        $sql = "SELECT * FROM users WHERE reset_token = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function updatePasswordByToken(int $userId, string $hashedPassword)
    {
        $sql = "UPDATE $this->tableName SET password_hash = :password, reset_token = NULL WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $userId
        ]);
    }
    public function updateAddressId($userId, $addressId)
    {
        $sql = "UPDATE users SET address_id = :address_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'address_id' => $addressId,
            'id' => $userId
        ]);
    }
}

?>