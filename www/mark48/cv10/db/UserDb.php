<?php

require_once "DbPdo.php";
require_once "classes/User.php";

class UserDb
{
    private $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }


    /**
     * Vytvoří nového uživatele v DB.
     * @return bool True při úspěchu, false pokud email existuje.
     */
    public function createUser(string $name, string $email, string $password): bool
    {
        // Kontrola existence emailu
        $stmt = $this->pdo->prepare("SELECT 1 FROM cv10_users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetchColumn()) {
            return false;
        }

        // Zahashování hesla
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Vložení uživatele (včetně name a privilege=1)
        $stmt = $this->pdo->prepare(
            "INSERT INTO cv10_users (name, email, password, privilege)
             VALUES (:name, :email, :password, 1)"
        );
        $stmt->execute([
            'name'     => $name,
            'email'    => $email,
            'password' => $hash,
        ]);

        return true;
    }
    /**
     * Najde uživatele podle emailu.
     * @return User|null
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cv10_users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row) {
            return new User(
                $row['user_id'],
                $row['email'],
                $row['password'],
                $row['privilege'],
                $row['name']
            );
        }

        return null;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT user_id, name, email, privilege FROM cv10_users ORDER BY user_id");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function updateUserPrivileges($userId, $priv)
    {
        $stmt = $this->pdo->prepare("UPDATE cv10_users SET privilege = :priv WHERE user_id = :id");
        $stmt->execute([
            'priv' => $priv,
            'id'   => $userId
        ]);
    }
}
