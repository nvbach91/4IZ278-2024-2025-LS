<?php
require_once __DIR__ . '/Database.php';

class UserDB {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function getUserById(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT first_name, last_name, email, street, city, zip, country
            FROM users
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(int $userId, string $street, string $city, string $zip, string $country, ?string $password = null): void {
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("
                UPDATE users 
                SET street = ?, city = ?, zip = ?, country = ?, password = ? 
                WHERE id = ?
            ");
            $stmt->execute([$street, $city, $zip, $country, $hashed, $userId]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE users 
                SET street = ?, city = ?, zip = ?, country = ? 
                WHERE id = ?
            ");
            $stmt->execute([$street, $city, $zip, $country, $userId]);
        }
    }
}