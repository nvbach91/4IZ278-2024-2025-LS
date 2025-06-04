<?php
require_once __DIR__ . '/../db/Database.php';

class User
{
    private $db;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;
    public $created_at;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function register($username, $email, $password)
    {
        if ($this->userExists($username, $email)) {
            return false;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (username, email, password, role, created_at) 
                  VALUES (:username, :email, :password, 'user', NOW())";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }
    public function login($email, $password)
    {
        $query = "SELECT id, username, email, password, role FROM " . $this->table . " 
                  WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                return $row; 
            }
        }
        return false;
    }

    private function userExists($username, $email)
    {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE username = :username OR email = :email LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
