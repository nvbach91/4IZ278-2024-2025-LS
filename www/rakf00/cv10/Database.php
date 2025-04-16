<?php

require_once "php-config.php";

class Database
{

    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                ],
            );
        } catch (PDOException $e) {
            error_log("Chyba připojení k databázi: " . $e->getMessage());
            die("Chyba připojení k databázi.");
        }
    }

    public function fetch($args)
    {
        $sql = "SELECT * FROM usersLogin";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function registerUser($email, $password)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO usersLogin (email, password, privilege) VALUES (?, ?,1)",
        );
        try {
            return $stmt->execute(
                [$email, password_hash($password, PASSWORD_DEFAULT)],
            );
        } catch (PDOException $e) {
            echo "chyba: " . $e->getMessage();
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $sql =  "SELECT * FROM usersLogin WHERE email = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Uživatel s tímto emailem neextisuje";
        }
    }
}
