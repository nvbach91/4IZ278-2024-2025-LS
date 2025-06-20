<?php
require_once "Database.php";

class UsersDB extends Database
{
    protected $tableName = "users";

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Najdi uživatele podle emailu (přihlašování)
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registrace nového uživatele 
    public function insert($name, $email, $passwordHash, $avatar = null)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName} (name, email, password, avatar, role) VALUES (?, ?, ?, ?, 'user')");
        return $stmt->execute([$name, $email, $passwordHash, $avatar]);
    }

    // Změna hesla
    public function updatePassword($id, $passwordHash)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET password = ? WHERE id = ?");
        return $stmt->execute([$passwordHash, $id]);
    }

    // Úprava profilu
    public function updateProfileWithAddress($id, $name, $avatarPath, $shipping_name, $shipping_street, $shipping_postal_code, $shipping_city, $shipping_phone)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET name = ?, avatar = ?, shipping_name = ?, shipping_street = ?, shipping_postal_code = ?, shipping_city = ?, shipping_phone = ? WHERE id = ?");
        return $stmt->execute([
            $name, $avatarPath, $shipping_name, $shipping_street, $shipping_postal_code, $shipping_city, $shipping_phone, $id
        ]);
    }

    // Smazání uživatele
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function fetchAll()
    {
        return $this->pdo->query("SELECT * FROM {$this->tableName}")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchFiltered($filters)
    {
        return $this->fetchAll();
    }
}
