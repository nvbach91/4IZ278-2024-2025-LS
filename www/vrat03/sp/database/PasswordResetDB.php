<?php require_once __DIR__.'/Database.php';?>
<?php

class PasswordResetDB extends Database {
    protected $tableName = 'sp_eshop_password_resets';

    public function storePasswordResetToken(int $userId, string $token, string $expires){
        $sql = "INSERT INTO $this->tableName (user_id, token, expires) VALUES (:user_id, :token, :expires)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['user_id' => $userId, 'token' => $token, 'expires' => $expires]);
    }

    public function fetchPasswordResetByToken(string $token) {
        $sql = "SELECT * FROM $this->tableName WHERE token = :token";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['token' => $token]);
        return $statement->fetch();
    }

    public function deletePasswordResetByToken(string $token) {
        $sql = "DELETE FROM $this->tableName WHERE token = :token";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['token' => $token]);
    }
}

?>