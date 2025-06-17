<?php
// sp/database/User.php

namespace App;

use PDO;

class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function exists(string $email): bool {
        $stmt = $this->pdo->prepare('SELECT 1 FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return (bool)$stmt->fetch();
    }

    public function create(string $name, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)'
        );
        return $stmt->execute([
            'name'  => $name,
            'email' => $email,
            'pass'  => $hash
        ]);
    }

    public function verifyPassword(int $userId, string $password): bool {
        $stmt = $this->pdo->prepare('SELECT password FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch();
        return $row && password_verify($password, $row['password']);
    }

    public function updatePassword(int $userId, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            'UPDATE users SET password = :pass, updated_at = NOW() WHERE id = :id'
        );
        return $stmt->execute(['pass' => $hash, 'id' => $userId]);
    }

    /**
     * ADMIN: vrátí všechny uživatele
     */
    public function getAllUsers(): array {
        $stmt = $this->pdo->query(
            'SELECT id, name, email, created_at FROM users ORDER BY created_at DESC'
        );
        return $stmt->fetchAll();
    }

    /**
     * ADMIN: smaže uživatele podle ID
     */
    public function deleteUser(int $userId): bool {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute(['id' => $userId]);
    }
}
